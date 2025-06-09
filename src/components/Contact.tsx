import React, { useState } from 'react';
import { Mail, Send, User, MessageSquare } from 'lucide-react';
import AnimatedSection from './AnimatedSection';

interface ContactProps {
  showModal: (title: string, message: string, isError?: boolean) => void;
}

const Contact: React.FC<ContactProps> = ({ showModal }) => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    subject: '',
    message: ''
  });

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    showModal('Mesaj Gönderilemedi', 'Bu sadece bir demo mesajıdır.', false);
    setFormData({
      name: '',
      email: '',
      subject: '',
      message: ''
    });
  };

  return (
    <div className="p-8">
      <AnimatedSection>
        <div className="text-center mb-12">
          <div className="flex justify-center mb-6">
            <div className="bg-gradient-to-br from-blue-500 to-purple-600 p-4 rounded-2xl shadow-lg">
              <Mail className="h-12 w-12 text-white" />
            </div>
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-4">
            📧 İletişim
          </h1>
          <p className="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
            Görüş, öneri ve sorularınız için bize ulaşın.
          </p>
        </div>
      </AnimatedSection>

      <AnimatedSection delay={100}>
        <div className="max-w-2xl mx-auto">
          <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form onSubmit={handleSubmit} className="space-y-6">
              <div className="grid md:grid-cols-2 gap-6">
                <div>
                  <label className="block text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <User className="h-5 w-5 mr-2 text-blue-600" />
                    Adınız Soyadınız
                  </label>
                  <input
                    type="text"
                    name="name"
                    value={formData.name}
                    onChange={handleInputChange}
                    required
                    className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Adınızı ve soyadınızı girin"
                  />
                </div>

                <div>
                  <label className="block text-lg font-semibold text-gray-800 mb-3 flex items-center">
                    <Mail className="h-5 w-5 mr-2 text-blue-600" />
                    E-posta Adresiniz
                  </label>
                  <input
                    type="email"
                    name="email"
                    value={formData.email}
                    onChange={handleInputChange}
                    required
                    className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="ornek@email.com"
                  />
                </div>
              </div>

              <div>
                <label className="block text-lg font-semibold text-gray-800 mb-3 flex items-center">
                  <MessageSquare className="h-5 w-5 mr-2 text-blue-600" />
                  Konu
                </label>
                <input
                  type="text"
                  name="subject"
                  value={formData.subject}
                  onChange={handleInputChange}
                  required
                  className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                  placeholder="Mesajınızın konusu"
                />
              </div>

              <div>
                <label className="block text-lg font-semibold text-gray-800 mb-3">
                  Mesajınız
                </label>
                <textarea
                  name="message"
                  value={formData.message}
                  onChange={handleInputChange}
                  rows={6}
                  required
                  className="block w-full p-4 border border-gray-300 rounded-xl bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                  placeholder="Mesajınızı buraya yazın..."
                />
              </div>

              <div className="text-center pt-4">
                <button
                  type="submit"
                  className="flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 mx-auto"
                >
                  <Send className="h-5 w-5" />
                  <span>Gönder</span>
                </button>
              </div>
            </form>
          </div>

          <div className="mt-8 bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl shadow-lg border border-gray-100 p-6 text-center">
            <h3 className="text-xl font-semibold text-gray-800 mb-4">Direkt İletişim</h3>
            <div className="space-y-2">
              <p className="text-gray-700">
                <strong>E-Mail:</strong> ozkanahmet@protonmail.com
              </p>
              <p className="text-gray-600 text-sm">
                Genellikle 24 saat içinde yanıtlıyoruz
              </p>
            </div>
          </div>
        </div>
      </AnimatedSection>
    </div>
  );
};

export default Contact;