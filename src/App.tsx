import React, { useState } from 'react';
import { Leaf, Camera, Droplets, Users, Mail, Menu, X } from 'lucide-react';
import Navigation from './components/Navigation';
import PhotoAnalysis from './components/PhotoAnalysis';
import DrugAdvice from './components/DrugAdvice';
import SmartIrrigation from './components/SmartIrrigation';
import About from './components/About';
import Contact from './components/Contact';
import Modal from './components/Modal';

export type PageType = 'photo' | 'advice' | 'irrigation' | 'about' | 'contact';

function App() {
  const [currentPage, setCurrentPage] = useState<PageType>('photo');
  const [modal, setModal] = useState<{ isOpen: boolean; title: string; message: string; isError: boolean }>({
    isOpen: false,
    title: '',
    message: '',
    isError: false
  });

  const showModal = (title: string, message: string, isError = false) => {
    setModal({ isOpen: true, title, message, isError });
  };

  const closeModal = () => {
    setModal(prev => ({ ...prev, isOpen: false }));
  };

  const renderCurrentPage = () => {
    switch (currentPage) {
      case 'photo':
        return <PhotoAnalysis showModal={showModal} />;
      case 'advice':
        return <DrugAdvice showModal={showModal} />;
      case 'irrigation':
        return <SmartIrrigation showModal={showModal} />;
      case 'about':
        return <About />;
      case 'contact':
        return <Contact showModal={showModal} />;
      default:
        return <PhotoAnalysis showModal={showModal} />;
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
      <Navigation currentPage={currentPage} setCurrentPage={setCurrentPage} />
      
      <main className="container mx-auto max-w-6xl px-4 py-8">
        <div className="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
          {renderCurrentPage()}
        </div>
      </main>

      <Modal
        isOpen={modal.isOpen}
        onClose={closeModal}
        title={modal.title}
        message={modal.message}
        isError={modal.isError}
      />
    </div>
  );
}

export default App;