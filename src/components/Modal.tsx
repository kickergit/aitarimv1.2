import React, { useEffect } from 'react';
import { X, AlertCircle, CheckCircle } from 'lucide-react';

interface ModalProps {
  isOpen: boolean;
  onClose: () => void;
  title: string;
  message: string;
  isError?: boolean;
}

const Modal: React.FC<ModalProps> = ({ isOpen, onClose, title, message, isError = false }) => {
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'unset';
    }

    return () => {
      document.body.style.overflow = 'unset';
    };
  }, [isOpen]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div 
        className="absolute inset-0 bg-black/60 backdrop-blur-sm"
        onClick={onClose}
      />
      <div className="relative bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-md w-full mx-4 transform transition-all duration-300 scale-100">
        <div className="p-6">
          <div className="flex items-center justify-between mb-4">
            <div className="flex items-center space-x-3">
              {isError ? (
                <AlertCircle className="h-6 w-6 text-red-600" />
              ) : (
                <CheckCircle className="h-6 w-6 text-green-600" />
              )}
              <h3 className={`text-xl font-semibold ${isError ? 'text-red-700' : 'text-green-700'}`}>
                {title}
              </h3>
            </div>
            <button
              onClick={onClose}
              className="p-1 rounded-lg hover:bg-gray-100 transition-colors"
            >
              <X className="h-5 w-5 text-gray-500" />
            </button>
          </div>
          
          <p className="text-gray-700 mb-6 leading-relaxed">
            {message}
          </p>
          
          <div className="flex justify-end">
            <button
              onClick={onClose}
              className={`px-6 py-2 rounded-lg font-semibold transition-colors ${
                isError
                  ? 'bg-red-600 hover:bg-red-700 text-white'
                  : 'bg-green-600 hover:bg-green-700 text-white'
              }`}
            >
              Kapat
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Modal;