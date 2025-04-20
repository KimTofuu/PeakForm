import React from 'react';

const GoogleSignUpButton = () => {
    const handleSignUp = () => {
        // Logic to initiate Google sign-up process
        window.location.href = '/auth/google'; // Adjust the URL as needed for your backend
    };

    return (
        <button className="google-signup-btn" onClick={handleSignUp}>
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" />
            Sign up with Google
        </button>
    );
};

export default GoogleSignUpButton;