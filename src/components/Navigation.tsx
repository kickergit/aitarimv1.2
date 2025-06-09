import React, { useState } from 'react';
import { Leaf, Camera, Droplets, Users, Mail, Menu, X, Pill } from 'lucide-react';
import { PageType } from '../App';

interface NavigationProps {
  currentPage: PageType;
  setCurrentPage: (page: PageType) => void;
}

const Navigation: React.FC<NavigationProps> = ({ currentPage, setCurrentPage }) => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  const navItems = [
    { id: 'photo' as PageType, label: 'Fotoğraf Analiz', icon: Camera },
    { id: 'advice' as PageType, label: 'İlaç/Besin Tavsiyesi', icon: Pill },
    { id: 'irrigation' as PageType, label: 'Akıllı Sulama', icon: Droplets },
    { id: 'about' as PageType, label: 'Hakkımızda', icon: Users },
    { id: 'contact' as PageType, label: 'İletişim', icon: Mail },
  ];

  return (
    <nav className="bg-gradient-to-r from-green-700 via-green-600 to-emerald-600 text-white shadow-2xl sticky top-0 z-50 backdrop-blur-sm">
      <div className="container mx-auto max-w-7xl px-4">
        <div className="flex justify-between items-center py-4">
          {/* Logo */}
          <div className="flex items-center space-x-3">
            <div className="bg-white/20 p-2 rounded-xl backdrop-blur-sm">
              <Leaf className="h-8 w-8 text-green-100" />
            </div>
            <div>
              <h1 className="text-2xl font-bold tracking-tight">AI Tarım</h1>
              <p className="text-green-100 text-xs">Akıllı Tarım Çözümleri</p>
            </div>
          </div>

          {/* Desktop Navigation */}
          <div className="hidden lg:flex items-center space-x-1">
            {navItems.map((item) => {
              const Icon = item.icon;
              return (
                <button
                  key={item.id}
                  onClick={() => setCurrentPage(item.id)}
                  className={`flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-300 ${
                    currentPage === item.id
                      ? 'bg-white/20 text-white shadow-lg backdrop-blur-sm'
                      : 'text-green-100 hover:bg-white/10 hover:text-white'
                  }`}
                >
                  <Icon className="h-4 w-4" />
                  <span className="font-medium">{item.label}</span>
                </button>
              );
            })}
          </div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            className="lg:hidden p-2 rounded-xl bg-white/20 backdrop-blur-sm"
          >
            {isMobileMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </button>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <div className="lg:hidden pb-4 border-t border-white/20 mt-4 pt-4">
            <div className="space-y-2">
              {navItems.map((item) => {
                const Icon = item.icon;
                return (
                  <button
                    key={item.id}
                    onClick={() => {
                      setCurrentPage(item.id);
                      setIsMobileMenuOpen(false);
                    }}
                    className={`w-full flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 ${
                      currentPage === item.id
                        ? 'bg-white/20 text-white shadow-lg backdrop-blur-sm'
                        : 'text-green-100 hover:bg-white/10 hover:text-white'
                    }`}
                  >
                    <Icon className="h-5 w-5" />
                    <span className="font-medium">{item.label}</span>
                  </button>
                );
              })}
            </div>
          </div>
        )}
      </div>
    </nav>
  );
};

export default Navigation;