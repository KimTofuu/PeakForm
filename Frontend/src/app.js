import React from 'react';
import ReactDOM from 'react-dom';
import GoogleSignUpButton from './components/GoogleSignUpButton';
import './styles/main.css';

const App = () => {
    return (
        <div className="app-container">
            <h1>Welcome to PeakForm</h1>
            <GoogleSignUpButton />
        </div>
    );
};

ReactDOM.render(<App />, document.getElementById('root'));