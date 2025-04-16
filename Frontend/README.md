# PeakForm App

## Overview
PeakForm is a web application that allows users to sign up and log in using their Google accounts. This project is structured into two main parts: the Backend and the Frontend. The Backend handles the server-side logic, while the Frontend provides the user interface.

## Project Structure
```
PeakForm-app
├── Backend
│   ├── app
│   ├── bootstrap
│   ├── config
│   ├── database
│   ├── public
│   ├── resources
│   │   ├── views
│   │   │   └── login.blade.php
│   ├── routes
│   ├── storage
│   └── tests
├── Frontend
│   ├── public
│   │   └── index.html
│   ├── src
│   │   ├── components
│   │   │   └── GoogleSignUpButton.js
│   │   ├── styles
│   │   │   └── main.css
│   │   └── app.js
│   └── package.json
└── README.md
```

## Frontend Setup
1. Navigate to the `Frontend` directory:
   ```
   cd Frontend
   ```

2. Install the necessary dependencies:
   ```
   npm install
   ```

3. Start the development server:
   ```
   npm start
   ```

## Google Sign-Up Feature
The application includes a Google sign-up feature that allows users to authenticate using their Google accounts. The sign-up button is implemented in the `GoogleSignUpButton.js` component, which handles the click event to initiate the sign-up process.

## Contributing
Contributions are welcome! Please feel free to submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.