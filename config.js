// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getAuth } from 'firebase/auth';
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyBMAcRpSQPbVmOKhEn4rMXXV2JoxcXAT4U",
  authDomain: "librecripto.firebaseapp.com",
  projectId: "librecripto",
  storageBucket: "librecripto.appspot.com",
  messagingSenderId: "592880129684",
  appId: "1:592880129684:web:34200c0672285e00dc8681",
  measurementId: "G-PRQ96T8TK7"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
//const analytics = getAnalytics(app);
const auth = getAuth(app);
export { auth, app };