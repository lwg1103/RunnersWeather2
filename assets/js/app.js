import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import '../css/app.css';
import Home from './components/Home';

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
            .then(function (registration) {
                console.log('Registration sw, scope: ', registration.scope);
            })
            .catch(function (error) {
                console.log('Registration failes, error: ', error);
            });
}

ReactDOM.render(<Router><Home /></Router>, document.getElementById('root'));