import React, { useState } from 'react';
import { Pill, Upload, Trash2, Loader, AlertTriangle } from 'lucide-react';
import AnimatedSection from './AnimatedSection';

interface DrugAdviceProps {
  showModal: (title: string, message: string, isError?: boolean) => void;
}

const DrugAdvice: React.FC<DrugAdviceProps> = ({ showModal }) => {
  const [selectedImages, setSelectedImages] = useState<File[]>([]);
  const [imagePreviewUrls, setImagePreviewUrls] = useState<string[]>([]);
  const [userInput, setUserInput] = useState('');
  const [isAnalyzing, setIsAnalyzing] = useState(false);
  const [analysisResult, setAnalysisResult] = useState('');
  const [showResults, setShowResults] = useState(false);

  const apiKey = "AIzaSyDkgRnTa9UqOlFEtUqhkAAs5XkI-IfDfcY";

  const handleImageUpload = (event: React.ChangeEvent<HTMLInputElement>) => {
    const files = Array.from(event.target.files || []);
    setSelectedImages(files);

    const urls = files.map(file => URL.createObjectURL(file));
    setImagePreviewUrls(urls);
  };

  const clearAll = () => {
    setSelectedImages([]);
    setImagePreviewUrls([]);
    setUserInput('');
    setAnalysisResult('');
    setShowResults(false);
    
    imagePreviewUrls.forEach(url => URL.revokeObjectURL(url));
  };

  const getAdvice = async () => {
    if (!userInput.trim()) {
      showModal('Uyarı', 'Lütfen hastalık, zararlı veya ihtiyacınızı belirtin.', true);
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

      let promptText = `Bir Türk ziraat mühendisi gibi davranarak, kullanıcının belirttiği tarımsal sorun için etken madde tavsiyeleri sun. Cevaplarını verirken ŞU KURALLARA KESİNLİKLE UY:
1.  **SADECE ETKEN MADDE:** Asla ticari marka veya ürün adı verme. Sadece etken madde (Örn: "Bakır Sülfat", "Azoxystrobin", "Mancozeb") öner.
2.  **YASAL KONTROL:** Önerdiğin etken maddelerin Türkiye'de güncel olarak ruhsatlı ve kullanımının yasal olduğundan emin ol. Örneğin son yıllarda yasaklanan "Chlorpyrifos" gibi maddeleri ASLA önerme. Bilginin T.C. Tarım ve Orman Bakanlığı'nın güncel BKÜ veritabanına uygun olduğunu varsayarak cevap ver.
3.  **YASAL UYARI:** Cevabının BAŞINA ve SONUNA MUTLAKA aşağıdaki yasal uyarı metnini EKSİKSİZ olarak, formatını bozmadan ekle.
---
**⚠️ DİKKAT: YASAL UYARI VE BİLGİLENDİRME ⚠️**
Bu tavsiyeler yapay zeka tarafından, genel bilgilere dayanılarak üretilmiştir ve **KESİNLİKLE RESMİ BİR REÇETE VEYA TAVSİYE DEĞİLDİR.**
- **DOĞRU BİLGİ İÇİN:** Her zaman T.C. Tarım ve Orman Bakanlığı'nın güncel Bitki Koruma Ürünleri (BKÜ) Veri Tabanı'nı (bku.tarimorman.gov.tr) kontrol ediniz.
- **KULLANIM ÖNCESİ:** Alacağınız ürünün etiketini mutlaka okuyunuz. Dozaj, son ilaçlama ile hasat arası süre ve güvenlik önlemlerine harfiyen uyunuz.
- **UZMAN GÖRÜŞÜ:** En doğru ve güvenilir çözüm için bölgenizdeki bir Ziraat Mühendisine veya yetkili bir tarım danışmanına başvurunuz.
Hatalı ve bilinçsiz ilaç/gübre kullanımı hem sağlığınıza hem de çevreye ciddi zararlar verebilir.
---
Şimdi, kullanıcının sorgusunu bu kurallara göre cevapla: "${userInput}"`;

      const parts = [{ text: promptText }];
      if (imageFilesData.length > 0) {
        parts.push({ text: "\nKullanıcı ayrıca şu destekleyici fotoğraf(lar)ı yükledi:" });
        imageFilesData.forEach(imgData => parts.push({ inlineData: imgData }));
      }

      const payload = {
        contents: [{ parts: parts }]
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
      showModal('Tavsiye Hatası', `Bir hata oluştu: ${error instanceof Error ? error.message : 'Bilinmeyen hata'}`, true);
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
            <div className="bg-gradient-to-br from-yellow-500 to-orange-600 p-4 rounded-2xl shadow-lg">
              <Pill className="h-12 w-12 text-white" />
            </div>
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-4">
            💊 İlaç ve Besin Tavsiyesi 💊
          </h1>
          <p className="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
            Hastalık, zararlı veya ihtiyacı yazın, yapay zekadan etken madde önerileri alın.
          </p>
        </div>
      </AnimatedSection>

      <AnimatedSection delay={100}>
        <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
          <label className="block text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <Upload className="h-5 w-5 mr-2 text-yellow-600" />
            Destekleyici Fotoğraf Seçin (İsteğe Bağlı)
          </label>
          <input
            type="file"
            accept="image/png, image/jpeg"
            multiple
            onChange={handleImageUpload}
            className="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 p-4 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 transition-colors"
          />
        </div>
      </AnimatedSection>

      {imagePreviewUrls.length > 0 && (
        <AnimatedSection delay={200}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 className="text-xl font-semibold text-gray-800 mb-4">Fotoğraf Önizleme</h2>
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
          </div>
        </AnimatedSection>
      )}

      <AnimatedSection delay={300}>
        <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
          <label className="block text-lg font-semibold text-gray-800 mb-4">
            Hastalık / Zararlı / İhtiyaç Nedir?
          </label>
          <textarea
            value={userInput}
            onChange={(e) => setUserInput(e.target.value)}
            rows={4}
            className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-base resize-none"
            placeholder="Örn: Domateste mildiyö, yaprak biti, sarı yapraklar için demir takviyesi..."
          />
        </div>
      </AnimatedSection>

      <AnimatedSection delay={400}>
        <div className="flex flex-col sm:flex-row gap-4 justify-center mb-8">
          <button
            onClick={getAdvice}
            disabled={!userInput.trim() || isAnalyzing}
            className="flex items-center justify-center space-x-2 bg-gradient-to-r from-yellow-600 to-orange-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:from-yellow-700 hover:to-orange-700 disabled:from-gray-400 disabled:to-gray-500 disabled:cursor-not-allowed transition-all duration-300 transform hover:scale-105 disabled:hover:scale-100"
          >
            {isAnalyzing ? (
              <>
                <Loader className="h-5 w-5 animate-spin" />
                <span>Tavsiye Alınıyor...</span>
              </>
            ) : (
              <>
                <Pill className="h-5 w-5" />
                <span>Tavsiye Al</span>
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
        <AnimatedSection delay={500}>
          <div className="bg-gradient-to-br from-yellow-50 to-orange-50 rounded-2xl shadow-lg border border-yellow-200 p-8">
            <h2 className="text-2xl font-bold text-yellow-800 mb-6 flex items-center">
              <AlertTriangle className="h-6 w-6 mr-2" />
              ⚠️ Tavsiye Sonuçları ve Yasal Uyarı
            </h2>
            <div className="bg-white rounded-xl p-6 shadow-inner border border-yellow-100">
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

export default DrugAdvice;