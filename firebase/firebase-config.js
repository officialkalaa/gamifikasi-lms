const firebaseConfig = {
  apiKey: "AIzaSyDEtATBO4dAIWqjjKXvajj8EzIL4uCpwKE",
  authDomain: "gamifikasi-lms.firebaseapp.com",
  projectId: "gamifikasi-lms",
  storageBucket: "gamifikasi-lms.firebasestorage.app",
  messagingSenderId: "230584235856",
  appId: "1:230584235856:web:f0de60089e3e53af0a5e55",
};

firebase.initializeApp(firebaseConfig);

const db = firebase.firestore();
const auth = firebase.auth();

console.log("Firebase Connected");
