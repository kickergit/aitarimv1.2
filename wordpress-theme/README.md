# AI Tarım WordPress Teması

Modern, responsive WordPress teması. Yapay zeka destekli tarım analizi, ilaç tavsiyeleri ve akıllı sulama özellikleri için tasarlanmıştır.

## Özellikler

- **Modern Tasarım**: Tailwind CSS ile responsive ve modern arayüz
- **Özelleştirilebilir**: WordPress Customizer ile kolay düzenleme
- **SEO Optimized**: Arama motorları için optimize edilmiş
- **Hızlı Yükleme**: Optimize edilmiş kod ve kaynaklar
- **Accessibility**: Erişilebilirlik standartlarına uygun
- **Custom Post Types**: Hizmetler ve referanslar için özel içerik türleri
- **Gutenberg Uyumlu**: Yeni WordPress editörü ile tam uyumlu

## Kurulum

1. WordPress admin paneline giriş yapın
2. **Görünüm > Temalar** menüsüne gidin
3. **Yeni Ekle** butonuna tıklayın
4. **Tema Yükle** seçeneğini seçin
5. Tema dosyasını (.zip) yükleyin
6. **Etkinleştir** butonuna tıklayın

## Özelleştirme

### Customizer Ayarları

**Görünüm > Özelleştir** menüsünden aşağıdaki bölümleri düzenleyebilirsiniz:

#### Ana Sayfa Hero Bölümü
- Hero başlık
- Hero açıklama metni

#### Hizmetler Bölümü
- 3 farklı hizmet için başlık ve açıklama

#### Çağrı Bölümü (CTA)
- CTA başlık
- CTA açıklama
- CTA buton metni ve URL

#### İletişim Bilgileri
- E-posta adresi
- Telefon numarası
- Adres bilgisi

#### Sosyal Medya
- Facebook, Twitter, Instagram, LinkedIn, YouTube URL'leri

#### Footer Ayarları
- Footer açıklama metni
- Telif hakkı metni
- Geliştirici kredisi

### Menüler

**Görünüm > Menüler** bölümünden iki farklı menü konumu için menü oluşturabilirsiniz:

- **Primary Menu**: Ana navigasyon menüsü
- **Footer Menu**: Footer bölümündeki menü

### Özel İçerik Türleri

#### Hizmetler
- **Yazılar > Hizmetler** menüsünden yeni hizmetler ekleyebilirsiniz
- Her hizmet için ikon, renk ve özellikler belirleyebilirsiniz

#### Referanslar
- **Yazılar > Referanslar** menüsünden müşteri referansları ekleyebilirsiniz
- Şirket, pozisyon ve puan bilgileri ekleyebilirsiniz

### Widget Alanları

- **Sidebar**: Yan bar widget alanı
- **Footer Widget Area**: Footer widget alanı

## Sayfa Şablonları

- `index.php`: Ana sayfa şablonu
- `single.php`: Tekil yazı şablonu
- `page.php`: Sayfa şablonu
- `archive.php`: Arşiv şablonu
- `search.php`: Arama sonuçları şablonu
- `404.php`: 404 hata sayfası şablonu

## Teknik Özellikler

### Kullanılan Teknolojiler
- **PHP 7.4+**: WordPress standartları
- **Tailwind CSS**: Utility-first CSS framework
- **JavaScript ES6+**: Modern JavaScript özellikleri
- **Intersection Observer API**: Performanslı animasyonlar

### Performans Optimizasyonları
- Lazy loading desteği
- Optimize edilmiş CSS ve JavaScript
- Gereksiz WordPress özelliklerinin kaldırılması
- Debounced scroll events

### Güvenlik Özellikleri
- XSS koruması
- CSRF koruması
- Güvenlik başlıkları
- XML-RPC devre dışı

### SEO Özellikleri
- Semantic HTML5 yapısı
- Schema.org mikrodata desteği
- Open Graph meta etiketleri
- Optimize edilmiş sayfa başlıkları

## Tarayıcı Desteği

- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+
- Internet Explorer 11 (sınırlı destek)

## Geliştirici Notları

### Dosya Yapısı
```
wordpress-theme/
├── style.css              # Ana stil dosyası
├── index.php              # Ana şablon
├── header.php             # Header şablonu
├── footer.php             # Footer şablonu
├── functions.php          # Tema fonksiyonları
├── single.php             # Tekil yazı şablonu
├── page.php               # Sayfa şablonu
├── archive.php            # Arşiv şablonu
├── search.php             # Arama şablonu
├── 404.php                # 404 şablonu
├── comments.php           # Yorum şablonu
├── editor-style.css       # Gutenberg editör stilleri
├── js/
│   └── main.js            # Ana JavaScript dosyası
└── README.md              # Bu dosya
```

### Hook'lar ve Filter'lar

Tema aşağıdaki WordPress hook'larını kullanır:

- `after_setup_theme`: Tema kurulumu
- `wp_enqueue_scripts`: Script ve stil yükleme
- `widgets_init`: Widget alanları
- `customize_register`: Customizer ayarları
- `init`: Özel post türleri

### Özel Fonksiyonlar

- `ai_tarim_get_icon()`: SVG ikon çıktısı
- `ai_tarim_fallback_menu()`: Varsayılan menü
- `AI_Tarim_Walker_Nav_Menu`: Özel menü walker

## Destek

Tema ile ilgili sorularınız için:

- **E-posta**: ozkanahmet@protonmail.com
- **LinkedIn**: www.linkedin.com/in/ozkanaahmet

## Lisans

Bu tema GPL v2 veya üzeri lisans ile lisanslanmıştır.

## Changelog

### v1.2
- İlk sürüm
- Temel tema özellikleri
- Customizer entegrasyonu
- Özel post türleri
- Responsive tasarım
- SEO optimizasyonları

## Katkıda Bulunma

1. Projeyi fork edin
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

---

**Created by Ahmet Özkan with AI assistance**