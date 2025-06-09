import React, { useState } from 'react';
import { Camera, Upload, Trash2, Loader, Eye } from 'lucide-react';
import AnimatedSection from './AnimatedSection';

interface PhotoAnalysisProps {
  showModal: (title: string, message: string, isError?: boolean) => void;
}

const PhotoAnalysis: React.FC<PhotoAnalysisProps> = ({ showModal }) => {
  const [selectedImages, setSelectedImages] = useState<File[]>([]);
  const [imagePreviewUrls, setImagePreviewUrls] = useState<string[]>([]);
  const [analysisType, setAnalysisType] = useState('hastalik_zararli_tespiti');
  const [userNotes, setUserNotes] = useState('');
  const [isAnalyzing, setIsAnalyzing] = useState(false);
  const [analysisResult, setAnalysisResult] = useState('');
  const [showResults, setShowResults] = useState(false);

  const apiKey = "AIzaSyDkgRnTa9UqOlFEtUqhkAAs5XkI-IfDfcY";

  const analysisOptions = [
    { value: 'hastalik_zararli_tespiti', label: 'Hastalık ve Zararlı Tespiti' },
    { value: 'besin_eksikligi', label: 'Besin Eksikliği Analizi' },
    { value: 'gelisim_takibi', label: 'Genel Gelişim Takibi' },
    { value: 'sulama_onerisi_genel', label: 'Genel Sulama Önerisi (Bitki Türüne Göre)' },
    { value: 'toprak_yorumu', label: 'Toprak Görünümü Yorumlama (Fotoğraftan)' },
    { value: 'genel_analiz', label: 'Genel Bitki Sağlığı Analizi (Kapsamlı)' },
  ];

  const handleImageUpload = (event: React.ChangeEvent<HTMLInputElement>) => {
    const files = Array.from(event.target.files || []);
    setSelectedImages(files);

    // Create preview URLs
    const urls = files.map(file => URL.createObjectURL(file));
    setImagePreviewUrls(urls);
  };

  const clearAll = () => {
    setSelectedImages([]);
    setImagePreviewUrls([]);
    setUserNotes('');
    setAnalysisType('hastalik_zararli_tespiti');
    setAnalysisResult('');
    setShowResults(false);
    
    // Clean up object URLs
    imagePreviewUrls.forEach(url => URL.revokeObjectURL(url));
  };

  const analyzeImages = async () => {
    if (selectedImages.length === 0) {
      showModal('Uyarı', 'Lütfen önce analiz için en az bir fotoğraf seçin.', true);
      return;
    }

    setIsAnalyzing(true);
    setShowResults(false);

    try {
      const imageFilesData = await Promise.all(
        selectedImages.map(async (file) => {
          const base64 = await fileToBase64(file);
          return {
            data: base64.split(',')[1],
            mimeType: file.type
          };
        })
      );

      const selectedOption = analysisOptions.find(opt => opt.value === analysisType);
      const promptText = `Bu bitki fotoğraf(lar)ını analiz et. Seçilen analiz türü: "${selectedOption?.label}".\nKullanıcının ek notları/soruları: "${userNotes || 'Yok'}".\n\nCevabını net, anlaşılır ve maddeler halinde sun.`;

      const payload = {
        contents: [{
          parts: [
            { text: promptText },
            ...imageFilesData.map(img => ({ inlineData: img }))
          ]
        }]
      };

      const response = await fetch(
        `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`,
        {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload)
        }
      );

      if (!response.ok) {
        throw new Error(`API Hatası: ${response.status}`);
      }

      const result = await response.json();
      
      if (result.candidates && result.candidates[0]) {
        setAnalysisResult(result.candidates[0].content.parts[0].text);
        setShowResults(true);
      } else {
        throw new Error('API yanıtı beklenen formatta değil.');
      }
    } catch (error) {
      showModal('Analiz Hatası', `Bir hata oluştu: ${error instanceof Error ? error.message : 'Bilinmeyen hata'}`, true);
    } finally {
      setIsAnalyzing(false);
    }
  };

  const fileToBase64 = (file: File): Promise<string> => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result as string);
      reader.onerror = error => reject(error);
    });
  };

  return (
    <div className="p-8">
      <AnimatedSection>
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <div className="bg-gradient-to-br from-green-500 to-emerald-600 p-4 rounded-2xl shadow-lg">
              <Camera className="h-12 w-12 text-white" />
            </div>
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-4">
            🌿 Tarımda Yapay Zeka Destekli Bitki Analizi 🌿
          </h1>
          <p className="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
            Bitkilerinizin fotoğraflarını yükleyin, notlarınızı ekleyin ve analiz türünü seçerek 
            yapay zekadan detaylı bilgi alın!
          </p>
        </div>
      </AnimatedSection>

      <div className="grid lg:grid-cols-2 gap-8 mb-8">
        <AnimatedSection delay={100}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <label className="block text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <Upload className="h-5 w-5 mr-2 text-green-600" />
              Bitki Fotoğrafları Seçin
            </label>
            <input
              type="file"
              accept="image/png, image/jpeg"
              multiple
              onChange={handleImageUpload}
              className="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 p-4 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-colors"
            />
          </div>
        </AnimatedSection>

        <AnimatedSection delay={200}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <label className="block text-lg font-semibold text-gray-800 mb-4 flex items-center">
              <Eye className="h-5 w-5 mr-2 text-green-600" />
              Analiz Türü Seçin
            </label>
            <select
              value={analysisType}
              onChange={(e) => setAnalysisType(e.target.value)}
              className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base"
            >
              {analysisOptions.map(option => (
                <option key={option.value} value={option.value}>
                  {option.label}
                </option>
              ))}
            </select>
          </div>
        </AnimatedSection>
      </div>

      <AnimatedSection delay={300}>
        <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
          <h2 className="text-xl font-semibold text-gray-800 mb-4">Fotoğraf Önizleme</h2>
          <div className="border-2 border-dashed border-green-300 rounded-xl min-h-[200px] p-6 bg-green-50/50">
            {imagePreviewUrls.length > 0 ? (
              <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                {imagePreviewUrls.map((url, index) => (
                  <div key={index} className="relative group">
                    <img
                      src={url}
                      alt={`Preview ${index + 1}`}
                      className="w-full h-32 object-cover rounded-lg shadow-md transition-transform group-hover:scale-105"
                    />
                    <div className="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg" />
                  </div>
                ))}
              </div>
            ) : (
              <div className="flex flex-col items-center justify-center h-full text-gray-500">
                <Camera className="h-16 w-16 mb-4 text-gray-400" />
                <p className="text-lg">Lütfen bir veya daha fazla fotoğraf seçin</p>
              </div>
            )}
          </div>
        </div>
      </AnimatedSection>

      <AnimatedSection delay={400}>
        <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
          <label className="block text-lg font-semibold text-gray-800 mb-4">
            Ek Notlar veya Sorularınız (İsteğe Bağlı)
          </label>
          <textarea
            value={userNotes}
            onChange={(e) => setUserNotes(e.target.value)}
            rows={4}
            className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-base resize-none"
            placeholder="Gözlemleriniz, sorularınız..."
          />
        </div>
      </AnimatedSection>

      <AnimatedSection delay={500}>
        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-8">
          <button
            onClick={analyzeImages}
            disabled={selectedImages.length === 0 || isAnalyzing}
            className="flex items-center justify-center space-x-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:from-green-700 hover:to-emerald-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-105 disabled:hover:scale-100"
          >
            {isAnalyzing ? (
              <>
                <Loader className="h-5 w-5 animate-spin" />
                <span>Analiz Ediliyor...</span>
              </>
            ) : (
              <>
                <Eye className="h-5 w-5" />
                <span>Analiz Et</span>
              </>
            )}
          </button>
          
          <button
            onClick={clearAll}
            className="flex items-center justify-center space-x-2 bg-gray-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:bg-gray-700 transition-all duration-300 transform hover:scale-105"
          >
            <Trash2 className="h-5 w-5" />
            <span>Temizle</span>
          </button>
        </div>
      </AnimatedSection>

      {showResults && (
        <AnimatedSection delay={600}>
          <div className="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-lg border border-green-200 p-8">
            <h2 className="text-2xl font-bold text-green-700 mb-6 flex items-center">
              <Eye className="h-6 w-6 mr-2" />
              🔍 Analiz Sonuçları
            </h2>
            <div className="bg-white rounded-xl p-6 shadow-inner border border-green-100">
              <pre className="whitespace-pre-wrap text-gray-700 leading-relaxed font-sans">
                {analysisResult}
              </pre>
            </div>
          </div>
        </AnimatedSection>
      )}
    </div>
  );
};

export default PhotoAnalysis;