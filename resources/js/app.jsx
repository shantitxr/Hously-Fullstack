import './bootstrap';
import React from 'react';
import ReactDOM from 'react-dom/client';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import PropertyWizard from './components/PropertyWizard';

const queryClient = new QueryClient();

// Mount wizard wherever Blade renders a #property-wizard div
const el = document.getElementById('property-wizard');
if (el) {
    ReactDOM.createRoot(el).render(
        <QueryClientProvider client={queryClient}>
            <PropertyWizard />
        </QueryClientProvider>
    );
}