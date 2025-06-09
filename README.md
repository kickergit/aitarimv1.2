# 🌱 AI Tarım - Yapay Zeka Destekli Tarım Uygulaması v1.2

Modern web teknolojileri ile geliştirilmiş, yapay zeka destekli tarım analiz uygulaması.

## 🚀 Özellikler

- **📸 Fotoğraf Analizi**: Bitki hastalıkları ve zararlı tespiti
- **💊 İlaç Tavsiyesi**: Etken madde önerileri ve yasal uyarılar
- **💧 Akıllı Sulama**: FAO metodolojisi ile sulama hesaplaması
- **🌍 Hava Durumu Entegrasyonu**: Gerçek zamanlı meteoroloji verileri
- **📱 Responsive Tasarım**: Tüm cihazlarda mükemmel görünüm

## 🛠️ Teknolojiler

- **React 18** - Modern UI framework
- **TypeScript** - Type safety
- **Tailwind CSS** - Utility-first CSS
- **Vite** - Hızlı build tool
- **Lucide React** - Beautiful icons
- **Google Gemini AI** - Yapay zeka analizi

## 🌐 Canlı Demo

[https://kickergit.github.io/aitarimv1.2/](https://kickergit.github.io/aitarimv1.2/)

## 🔧 Kurulum

```bash
# Repository'yi klonlayın
git clone https://github.com/kickergit/aitarimv1.2.git

# Proje dizinine gidin
cd aitarimv1.2

# Bağımlılıkları yükleyin
npm install

# Geliştirme sunucusunu başlatın
npm run dev
```

## 📦 Build

```bash
# Production build
npm run build

# Build önizleme
npm run preview
```

## 🚀 Deployment

### GitHub Pages ile Otomatik Deployment

1. Repository'yi GitHub'a push edin
2. GitHub Actions otomatik olarak build ve deploy işlemini gerçekleştirir
3. `Settings > Pages` bölümünden GitHub Pages'i etkinleştirin

### Manuel Deployment

```bash
# Build ve deploy
npm run deploy
```

## ⚙️ Konfigürasyon

### API Anahtarları

Uygulamada kullanılan API anahtarları:

- **Google Gemini AI**: Bitki analizi için
- **Open-Meteo**: Hava durumu verileri için (ücretsiz)

### Ortam Değişkenleri

`.env` dosyası oluşturun:

```env
VITE_GEMINI_API_KEY=your_gemini_api_key_here
```

## 📝 Lisans

Bu proje MIT lisansı altında lisanslanmıştır.

## 👨‍💻 Geliştirici

**Ahmet Özkan**
- Email: ozkanahmet@protonmail.com
- www.linkedin.com/in/ozkanaahmet
- Phone: +90 539 950 33 95
- Created with AI assistance

## 🤝 Katkıda Bulunma

1. Fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Commit edin (`git commit -m 'Add amazing feature'`)
4. Push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

## ⚠️ Önemli Notlar

- Bu uygulama eğitim ve demo amaçlıdır
- Tarımsal kararlar için mutlaka uzman görüşü alın
- API kullanım limitlerini kontrol edin

## 📊 Özellik Roadmap

- [ ] Offline çalışma desteği
- [ ] Çoklu dil desteği
- [ ] Gelişmiş raporlama
- [ ] Mobil uygulama
- [ ] Veritabanı entegrasyonu
