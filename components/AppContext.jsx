import React, { createContext, useEffect, useState } from 'react'
import {
    createUserWithEmailAndPassword,
    signInWithEmailAndPassword,
    onAuthStateChanged,
    signOut, updateProfile,
    GoogleAuthProvider,
    signInWithPopup,
    sendPasswordResetEmail,
    FacebookAuthProvider,
    signInWithRedirect
} from 'firebase/auth'
import { collection, addDoc, setDoc, getFirestore, getDocs, doc, getDoc, query, where } from "firebase/firestore";
import { auth, app } from '../config'
import { useRouter } from "next/router"
import axios from 'axios'

export const AppContext = createContext()

const AppContextProvider = ({ children }) => {
    const router = useRouter();
    const [user, setUser] = useState(null)

    const signup = async (email, password, name) => {
        await createUserWithEmailAndPassword(auth, email, password)
            .then(() => {
                updateProfile(auth.currentUser, { displayName: name })
                router.push("/market")
            })
    }

    const db = getFirestore(app);

    useEffect(() => {
        if (user) {
            try { 
                const q = query(collection(db, "users"), where("uid", "==", user.uid));
                getDocs(q).then(res => {
                    if (res.docs.length === 0) {
                        setDoc(doc(db, "users", user.uid), {
                            uid: user.uid,
                            name: user.displayName,
                            authProvider: user.providerData[0].providerId,
                            email: user.email,
                            phone: user.phoneNumber,
                            image: user.photoURL,
                            createdAt: user.metadata.creationTime,
                            lastOperationDate: '',
                            totalOperations: '',
                            operationsPunctuation: '',
                            desc: ''
                        })
                        localStorage.setItem('user', JSON.stringify(user));
                        axios.put(
                            'https://api.chatengine.io/users/',
                            {"username": user.email, "secret": user.uid},
                            {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
                        )
                    }
                })
                localStorage.setItem('user', JSON.stringify(user));
            }
            catch (e) {
                console.log("Error getting cached document:", e);
            }
        }
    }, [user])

    const login = async (email, password) => { await signInWithEmailAndPassword(auth, email, password).then(
        localStorage.setItem('user', JSON.stringify(user.uid))
    ) };

    const logout = () => {
        signOut(auth)
        localStorage.clear()
        router.push("/acceder")
    };

    const loginWithGoogle = () => {
        const googleProvider = new GoogleAuthProvider();
        return signInWithPopup(auth, googleProvider);
    }

    const loginWithFacebook = () => {
        const facebookProvider = new FacebookAuthProvider();
        return signInWithPopup(auth, facebookProvider);
    }

    const resetPassword = (email) => {
        sendPasswordResetEmail(auth, email);
    }

    useEffect(() => {
        const unsuscribe = onAuthStateChanged(auth, currentUser => {
            setUser(currentUser)
        });
        return () => unsuscribe();
    }, [])

    return (
        <AppContext.Provider value={{
            user,
            signup,
            login,
            logout,
            loginWithGoogle,
            loginWithFacebook,
            resetPassword,
        }}>
            {children}
        </AppContext.Provider>
    )
}

export default AppContextProvider