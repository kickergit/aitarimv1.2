import React, { useState } from 'react';
import { Droplets, MapPin, Loader, Cloud, Sun, CloudRain } from 'lucide-react';
import AnimatedSection from './AnimatedSection';

interface SmartIrrigationProps {
  showModal: (title: string, message: string, isError?: boolean) => void;
}

interface WeatherData {
  current: {
    temperature_2m: number;
    weather_code: number;
  };
  daily: {
    et0_fao_evapotranspiration: number[];
    precipitation_sum: number[];
  };
}

const SmartIrrigation: React.FC<SmartIrrigationProps> = ({ showModal }) => {
  const [mode, setMode] = useState<'api' | 'manual'>('api');
  const [isLoading, setIsLoading] = useState(false);
  const [weatherData, setWeatherData] = useState<WeatherData | null>(null);
  const [locationName, setLocationName] = useState('');
  const [cityInput, setCityInput] = useState('');
  const [plantType, setPlantType] = useState('tomato');
  const [plantStage, setPlantStage] = useState('development');
  const [manualEto, setManualEto] = useState('');
  const [manualPrecip, setManualPrecip] = useState('');
  const [manualKc, setManualKc] = useState('');
  const [irrigationAdvice, setIrrigationAdvice] = useState<{
    html: string;
    className: string;
  } | null>(null);

  const KC_VALUES: Record<string, Record<string, number>> = {
    custom: { initial: 0.4, development: 0.7, mid: 1.15, late: 0.8 },
    tomato: { initial: 0.6, development: 1.15, mid: 1.15, late: 0.8 },
    corn: { initial: 0.3, development: 0.7, mid: 1.2, late: 0.6 },
    wheat: { initial: 0.4, development: 0.7, mid: 1.15, late: 0.4 },
    potato: { initial: 0.5, development: 0.75, mid: 1.15, late: 0.75 },
    sunflower: { initial: 0.35, development: 0.75, mid: 1.15, late: 0.35 },
  };

  const plantOptions = [
    { value: 'custom', label: 'Özel / Diğer' },
    { value: 'tomato', label: 'Domates' },
    { value: 'corn', label: 'Mısır' },
    { value: 'wheat', label: 'Buğday' },
    { value: 'potato', label: 'Patates' },
    { value: 'sunflower', label: 'Ayçiçeği' },
  ];

  const stageOptions = [
    { value: 'initial', label: 'Başlangıç (Fide)' },
    { value: 'development', label: 'Gelişme (Vejetatif)' },
    { value: 'mid', label: 'Orta Mevsim (Meyve/Başak)' },
    { value: 'late', label: 'Hasat Sonu' },
  ];

  const fetchWeatherByCoords = async (lat: number, lon: number, cityName?: string) => {
    setIsLoading(true);
    setWeatherData(null);
    setIrrigationAdvice(null);

    try {
      const weatherApiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code&daily=et0_fao_evapotranspiration,precipitation_sum&timezone=auto`;
      const response = await fetch(weatherApiUrl);
      
      if (!response.ok) {
        throw new Error(`Hava durumu API'sinden hata: ${response.status}`);
      }

      const data: WeatherData = await response.json();
      
      if (!data.current || !data.daily || !data.daily.et0_fao_evapotranspiration) {
        throw new Error("API'den beklenen veriler (ETo) alınamadı.");
      }

      setWeatherData(data);
      setLocationName(cityName || `Mevcut Konum (Lat: ${lat.toFixed(2)})`);
      updateIrrigationAdvice(data.daily.et0_fao_evapotranspiration[0], data.daily.precipitation_sum[0]);
    } catch (error) {
      showModal('Hava Durumu Hatası', `Bir sorun oluştu: ${error instanceof Error ? error.message : 'Bilinmeyen hata'}`, true);
    } finally {
      setIsLoading(false);
    }
  };

  const getCurrentLocation = () => {
    if (navigator.geolocation) {
      setCityInput('');
      navigator.geolocation.getCurrentPosition(
        (position) => fetchWeatherByCoords(position.coords.latitude, position.coords.longitude),
        (error) => showModal('Konum Hatası', `Konum izni alınamadı: ${error.message}`, true)
      );
    } else {
      showModal('Tarayıcı Uyumsuzluğu', 'Tarayıcınız konum servisini desteklemiyor.', true);
    }
  };

  const searchCity = async (e: React.FormEvent) => {
    e.preventDefault();
    const cityName = cityInput.trim();
    if (!cityName) {
      showModal('Giriş Hatası', 'Lütfen bir şehir adı girin.', true);
      return;
    }

    setIsLoading(true);
    try {
      const geocodeUrl = `https://geocoding-api.open-meteo.com/v1/search?name=${encodeURIComponent(cityName)}&count=1&language=tr&format=json`;
      const response = await fetch(geocodeUrl);
      const data = await response.json();
      
      if (!data.results || data.results.length === 0) {
        throw new Error(`'${cityName}' şehri bulunamadı.`);
      }

      const { latitude, longitude, name } = data.results[0];
      await fetchWeatherByCoords(latitude, longitude, name);
    } catch (error) {
      showModal('Şehir Arama Hatası', error instanceof Error ? error.message : 'Bilinmeyen hata', true);
      setIsLoading(false);
    }
  };

  const updateIrrigationAdvice = (eto: number, precip: number, manualKc?: number) => {
    if (eto === undefined || precip === undefined) return;

    const kc = manualKc ?? KC_VALUES[plantType][plantStage];
    const etc = eto * kc;
    const netWaterNeed = etc - precip;

    let adviceHTML = `
      <div class="p-4 bg-gray-100 rounded-lg border">
        <h3 class="text-xl font-bold text-gray-800 mb-3 text-center">Sulama Hesaplama Raporu</h3>
        <div class="grid grid-cols-2 gap-2 text-base">
          <span class="font-semibold">Ref. Su Tüketimi (ETo):</span>
          <span>${eto.toFixed(2)} mm/gün</span>
          <span class="font-semibold">Bitki Katsayısı (Kc):</span>
          <span>${kc.toFixed(2)}</span>
          <span class="font-semibold">Bitki Su Tüketimi (ETc):</span>
          <span class="font-bold">${etc.toFixed(2)} mm/gün</span>
          <span class="font-semibold">Günlük Yağış:</span>
          <span>-${precip.toFixed(2)} mm</span>
          <hr class="col-span-2 my-1">
          <span class="font-semibold text-lg">Net Sulama İhtiyacı:</span>
          <span class="font-bold text-lg">${netWaterNeed.toFixed(2)} mm</span>
        </div>
      </div>
    `;

    if (netWaterNeed > 1) {
      setIrrigationAdvice({
        className: 'bg-blue-100 border border-blue-300',
        html: adviceHTML + `
          <div class="mt-4 text-center">
            <h3 class="text-2xl font-bold text-blue-800 flex items-center justify-center">
              <span class="mr-2">💧</span> SULAMA ÖNERİLİR
            </h3>
            <p class="text-base text-blue-700">Bitkinizin bugün ${netWaterNeed.toFixed(2)} mm suya ihtiyacı var.</p>
          </div>
        `
      });
    } else {
      setIrrigationAdvice({
        className: 'bg-red-100 border border-red-300',
        html: adviceHTML + `
          <div class="mt-4 text-center">
            <h3 class="text-2xl font-bold text-red-800 flex items-center justify-center">
              <span class="mr-2">❌</span> SULAMA GEREKLİ DEĞİL
            </h3>
            <p class="text-base text-red-700">Yağış veya düşük su tüketimi nedeniyle bitkinizin ek suya ihtiyacı yok.</p>
          </div>
        `
      });
    }
  };

  const handleManualCalculation = () => {
    const eto = parseFloat(manualEto);
    const precip = parseFloat(manualPrecip) || 0;
    const kc = parseFloat(manualKc);

    if (!isNaN(eto) && !isNaN(kc)) {
      updateIrrigationAdvice(eto, precip, kc);
    }
  };

  const getWeatherIcon = (code: number) => {
    if (code === 0) return <Sun className="h-12 w-12" />;
    if (code <= 3) return <Cloud className="h-12 w-12" />;
    if (code <= 67) return <CloudRain className="h-12 w-12" />;
    return <Cloud className="h-12 w-12" />;
  };

  const getWeatherDescription = (code: number) => {
    const descriptions: Record<number, string> = {
      0: "Açık", 1: "Açık", 2: "Parçalı Bulutlu", 3: "Çok Bulutlu",
      45: "Sisli", 48: "Kırağı Sisi", 51: "Hafif Çisenti", 53: "Orta Çisenti",
      55: "Yoğun Çisenti", 61: "Hafif Yağmur", 63: "Orta Yağmur", 65: "Şiddetli Yağmur",
      71: "Hafif Kar", 73: "Orta Kar", 75: "Yoğun Kar", 80: "Hafif Sağanak",
      81: "Orta Sağanak", 82: "Şiddetli Sağanak", 95: "Fırtına",
      96: "Hafif Dolulu Fırtına", 99: "Şiddetli Dolulu Fırtına"
    };
    return descriptions[code] || "Bilinmiyor";
  };

  return (
    <div className="p-8">
      <AnimatedSection>
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <div className="bg-gradient-to-br from-blue-500 to-cyan-600 p-4 rounded-2xl shadow-lg">
              <Droplets className="h-12 w-12 text-white" />
            </div>
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-4">
            💧 Hassas Sulama Planlayıcı (FAO)
          </h1>
          <p className="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
            FAO Penman-Monteith formülüne dayalı, bilimsel sulama tavsiyeleri alın.
          </p>
        </div>
      </AnimatedSection>

      <AnimatedSection delay={100}>
        <div className="flex justify-center gap-4 mb-8">
          <button
            onClick={() => setMode('api')}
            className={`px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${
              mode === 'api'
                ? 'bg-blue-600 text-white shadow-lg'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            }`}
          >
            API ile Otomatik
          </button>
          <button
            onClick={() => setMode('manual')}
            className={`px-6 py-3 rounded-xl font-semibold transition-all duration-300 ${
              mode === 'manual'
                ? 'bg-blue-600 text-white shadow-lg'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            }`}
          >
            Manuel Hesaplama
          </button>
        </div>
      </AnimatedSection>

      {mode === 'api' && (
        <AnimatedSection delay={200}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 className="text-xl font-semibold text-gray-800 mb-6 text-center">1. Konum Belirleyin</h2>
            <div className="grid md:grid-cols-2 gap-6">
              <button
                onClick={getCurrentLocation}
                className="flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105"
              >
                <MapPin className="h-5 w-5" />
                <span>Konumumu Kullan</span>
              </button>
              
              <form onSubmit={searchCity} className="space-y-2">
                <label className="block text-sm font-medium text-gray-700">
                  Veya Şehir Adı Girin:
                </label>
                <input
                  type="text"
                  value={cityInput}
                  onChange={(e) => setCityInput(e.target.value)}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Örn: Konya (Enter'a basın)"
                />
              </form>
            </div>
          </div>
        </AnimatedSection>
      )}

      {mode === 'manual' && (
        <AnimatedSection delay={200}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 className="text-xl font-semibold text-gray-800 mb-6 text-center">1. Bilinen Değerleri Girin</h2>
            <div className="grid md:grid-cols-3 gap-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Referans Su Tüketimi (ETo)
                </label>
                <input
                  type="number"
                  step="0.1"
                  value={manualEto}
                  onChange={(e) => {
                    setManualEto(e.target.value);
                    handleManualCalculation();
                  }}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="5.5"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Günlük Yağış (mm)
                </label>
                <input
                  type="number"
                  step="0.1"
                  value={manualPrecip}
                  onChange={(e) => {
                    setManualPrecip(e.target.value);
                    handleManualCalculation();
                  }}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="0"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Bitki Katsayısı (Kc)
                </label>
                <input
                  type="number"
                  step="0.05"
                  value={manualKc}
                  onChange={(e) => {
                    setManualKc(e.target.value);
                    handleManualCalculation();
                  }}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="1.15"
                />
              </div>
            </div>
          </div>
        </AnimatedSection>
      )}

      {isLoading && (
        <AnimatedSection delay={300}>
          <div className="flex justify-center items-center py-12">
            <Loader className="h-12 w-12 animate-spin text-blue-600" />
          </div>
        </AnimatedSection>
      )}

      {weatherData && (
        <AnimatedSection delay={300}>
          <div className="bg-gradient-to-br from-blue-500 to-cyan-600 text-white rounded-2xl shadow-lg p-6 mb-8">
            <h2 className="text-2xl font-semibold mb-4 text-center">
              📍 {locationName} İçin Anlık Durum
            </h2>
            <div className="flex items-center justify-center space-x-6">
              <div className="text-center">
                {getWeatherIcon(weatherData.current.weather_code)}
              </div>
              <div className="text-center">
                <p className="text-4xl font-bold">{weatherData.current.temperature_2m.toFixed(1)}°C</p>
                <p className="text-xl">{getWeatherDescription(weatherData.current.weather_code)}</p>
              </div>
            </div>
          </div>
        </AnimatedSection>
      )}

      {(weatherData || mode === 'manual') && (
        <AnimatedSection delay={400}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div className="grid md:grid-cols-2 gap-6">
              <div>
                <label className="block text-md font-medium text-gray-700 mb-2">
                  2. Bitki Türü
                </label>
                <select
                  value={plantType}
                  onChange={(e) => {
                    setPlantType(e.target.value);
                    if (weatherData) {
                      updateIrrigationAdvice(
                        weatherData.daily.et0_fao_evapotranspiration[0],
                        weatherData.daily.precipitation_sum[0]
                      );
                    }
                  }}
                  disabled={mode === 'manual'}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                >
                  {plantOptions.map(option => (
                    <option key={option.value} value={option.value}>
                      {option.label}
                    </option>
                  ))}
                </select>
              </div>
              <div>
                <label className="block text-md font-medium text-gray-700 mb-2">
                  3. Bitki Gelişim Evresi
                </label>
                <select
                  value={plantStage}
                  onChange={(e) => {
                    setPlantStage(e.target.value);
                    if (weatherData) {
                      updateIrrigationAdvice(
                        weatherData.daily.et0_fao_evapotranspiration[0],
                        weatherData.daily.precipitation_sum[0]
                      );
                    }
                  }}
                  disabled={mode === 'manual'}
                  className="block w-full p-3 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
                >
                  {stageOptions.map(option => (
                    <option key={option.value} value={option.value}>
                      {option.label}
                    </option>
                  ))}
                </select>
              </div>
            </div>
          </div>
        </AnimatedSection>
      )}

      {irrigationAdvice && (
        <AnimatedSection delay={500}>
          <div className={`rounded-2xl shadow-lg p-6 ${irrigationAdvice.className}`}>
            <div dangerouslySetInnerHTML={{ __html: irrigationAdvice.html }} />
          </div>
        </AnimatedSection>
      )}
    </div>
  );
};

export default SmartIrrigation;