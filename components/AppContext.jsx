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
import { collection, addDoc, getFirestore, getDocs, query, where } from "firebase/firestore";
import { auth, app } from '../config'
import { useRouter } from "next/router"

export const AppContext = createContext()

const AppContextProvider = ({ children }) => {
    const router = useRouter();
    const [user, setUser] = useState(null)

    const signup = async (email, password, name) => {
        await createUserWithEmailAndPassword(auth, email, password)
            .then(() => {
                updateProfile(auth.currentUser, { displayName: name })
            })
    }

    const db = getFirestore(app);

    useEffect(() => {
        if (user) {
            const doc = addDoc(collection(db, "users"), {
                uid: user.uid,
                name: user.displayName,
                authProvider: user.providerData[0].providerId,
                email: user.email,
                image: user.photoURL,
                createdAt: user.metadata.creationTime
            })
            const userList = getDocs(query(collection(db, 'users'), where('uid', '===', user.uid)))
            if(userList.empty){
                doc()
            }
        }
    }, [user])

    const login = async (email, password) => { await signInWithEmailAndPassword(auth, email, password) };

    const logout = () => {
        signOut(auth)
        router.push("/")
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