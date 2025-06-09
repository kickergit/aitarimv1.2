import React from 'react';
import { Users, Target, CheckCircle, Mail } from 'lucide-react';
import AnimatedSection from './AnimatedSection';

const About: React.FC = () => {
  const features = [
    'Yapay zeka destekli bitki hastalığı ve zararlı tespiti',
    'Bitkilerdeki besin eksikliklerinin analizi',
    'Genel bitki gelişim takibi ve öneriler',
    'Konuma dayalı hava durumu verileriyle akıllı sulama tavsiyeleri',
    'Kullanıcıların ekleyebileceği notlar ve sorularla kişiselleştirilmiş analizler'
  ];

  return (
    <div className="p-8">
      <AnimatedSection>
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <div className="bg-gradient-to-br from-purple-500 to-indigo-600 p-4 rounded-2xl shadow-lg">
              <Users className="h-12 w-12 text-white" />
            </div>
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-4">
            🌱 Hakkımızda
          </h1>
          <p className="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
            AI Tarım: Tarımda teknolojinin gücüyle verimliliği arttırmayı hedefler.
          </p>
        </div>
      </AnimatedSection>

      <div className="grid lg:grid-cols-2 gap-12 mb-12">
        <AnimatedSection delay={100}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div className="flex items-center mb-6">
              <Target className="h-8 w-8 text-purple-600 mr-3" />
              <h2 className="text-2xl font-bold text-gray-800">Misyonumuz</h2>
            </div>
            <p className="text-gray-700 leading-relaxed text-lg mb-6">
              AI Tarım, çiftçilerimizin ve tarım meraklılarının bitki sağlığı konusunda bilinçli kararlar 
              almasına yardımcı olmak amacıyla geliştirilmiş modern bir web uygulamasıdır. Yapay zeka 
              teknolojilerini kullanarak, bitki fotoğraflarınız üzerinden hastalık, zararlı ve besin 
              eksikliği gibi sorunları tespit etmeyi hedefler.
            </p>
            <p className="text-gray-700 leading-relaxed text-lg">
              Misyonumuz, sürdürülebilir tarım pratiklerini destekleyerek, kaynakların daha verimli 
              kullanılmasını sağlamak ve tarımsal üretimi artırmaktır. Kullanıcı dostu arayüzümüz ve 
              anlaşılır analiz sonuçlarımızla, her seviyeden kullanıcının teknolojiden en iyi şekilde 
              faydalanmasını amaçlıyoruz.
            </p>
          </div>
        </AnimatedSection>

        <AnimatedSection delay={200}>
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <div className="flex items-center mb-6">
              <CheckCircle className="h-8 w-8 text-green-600 mr-3" />
              <h2 className="text-2xl font-bold text-gray-800">Neler Sunuyoruz?</h2>
            </div>
            <ul className="space-y-4">
              {features.map((feature, index) => (
                <li key={index} className="flex items-start">
                  <CheckCircle className="h-6 w-6 text-green-500 mr-3 mt-0.5 flex-shrink-0" />
                  <span className="text-gray-700 text-lg leading-relaxed">{feature}</span>
                </li>
              ))}
            </ul>
          </div>
        </AnimatedSection>
      </div>

      <AnimatedSection delay={300}>
        <div className="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-lg border border-green-200 p-8 text-center">
          <h2 className="text-2xl font-bold text-green-700 mb-4">Geleceğin Tarımı</h2>
          <p className="text-gray-700 leading-relaxed text-lg mb-6 max-w-4xl mx-auto">
            Gelişen teknolojiyi tarımla buluşturarak, geleceğin tarımına bugünden katkıda bulunmayı 
            hedefliyoruz. Geri bildirimleriniz ve önerileriniz bizim için değerlidir.
          </p>
          
          <div className="bg-white rounded-xl p-6 shadow-inner border border-green-100 max-w-2xl mx-auto">
            <div className="flex items-center justify-center mb-4">
              <Mail className="h-6 w-6 text-green-600 mr-2" />
              <h3 className="text-lg font-semibold text-gray-800">İletişim</h3>
            </div>
            <p className="text-gray-700 mb-2">
              <strong>E-Mail:</strong> ozkanahmet@protonmail.com
            </p>
            <p className="text-gray-600 text-sm">
              Created by Ahmet Özkan with AI
            </p>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};

export default About;
