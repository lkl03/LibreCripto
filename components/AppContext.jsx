import React, { createContext, useEffect } from 'react'
import {
    createUserWithEmailAndPassword,
    signInWithEmailAndPassword,
    onAuthStateChanged,
    signOut, updateProfile,
    GoogleAuthProvider,
    signInWithPopup,
    sendPasswordResetEmail,
    FacebookAuthProvider,
    signInWithRedirect,
    updatePassword,
    sendEmailVerification
} from 'firebase/auth'
import { collection, addDoc, setDoc, getFirestore, getDocs, doc, getDoc, query, where } from "firebase/firestore";
import { auth, app } from '../config'
import { useRouter } from "next/router"
import axios from 'axios'
import useState from 'react-usestateref'

export const AppContext = createContext()

const AppContextProvider = ({ children }) => {
    const router = useRouter();
    const [user, setUser] = useState(null)
    const [userPassword, setUserPassword, userPasswordRef] = useState('')
    const [userPublicID, setUserPublicID, userPublicIDRef] = useState('')
    
    const [datainEmail, setDatainEmail, datainEmailRef] = useState({
        email: '',
        name: '',
        password: ''
    })

    let randomstring = require("randomstring");

    const signup = async (email, password, name) => {
        await createUserWithEmailAndPassword(auth, email, password)
            .then(() => {
                updateProfile(auth.currentUser, { displayName: name })
                sendEmailVerification(auth.currentUser)
                //router.push("/market")
                setUserPassword(password)
                setDatainEmail({
                    email: email,
                    name: name,
                    password: password
                })
            })
    }

    const db = getFirestore(app);

    useEffect(() => {
        if (user) {
            const username = user?.displayName?.split(/\s+/).join('').toLowerCase()
            try { 
                const q = query(collection(db, "users"), where("uid", "==", user.uid));
                getDocs(q).then(res => {
                    if (res.docs.length === 0) {
                        let generatePublicID = randomstring.generate(9);
                        setUserPublicID(generatePublicID)
                        if(user.providerData[0].providerId == 'google.com'){
                            let passwordGenerated = randomstring.generate();
                            setUserPassword(passwordGenerated)
                            updatePassword(auth.currentUser, userPasswordRef.current).then(() => {
                                console.log('this is generated:' + passwordGenerated)
                                console.log('this is saved:' + userPasswordRef.current)
                            }).catch((error) => {
                                console.log(error)
                            });
                            setDatainEmail({
                                email: user.email,
                                name: user.displayName,
                                password: userPasswordRef.current
                            })
                            console.log(datainEmailRef.current)
                        }
                        setDoc(doc(db, "users", user.uid), {
                            uid: user.uid,
                            publicID: userPublicIDRef.current,
                            name: user.displayName,
                            authProvider: user.providerData[0].providerId,
                            email: user.email,
                            phone: user.phoneNumber,
                            image: user.photoURL,
                            createdAt: user.metadata.creationTime,
                            lastOperationDate: '',
                            totalOperations: 0,
                            operationsPunctuation: 0,
                            desc: '',
                            password: userPasswordRef.current
                        })
                        localStorage.setItem('user', JSON.stringify(user));
                        axios.put('https://api.chatengine.io/users/', {
                            username: userPublicIDRef.current,
                            first_name: user?.displayName,
                            email: user.email,
                            secret: user.uid
                        }, {
                            headers: {
                                "Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8',
                                "Content-Type": "application/json"
                            }
                        })
                        fetch("../api/welcome", {
                            "method": "POST",
                            "headers": { "content-type": "application/json" },
                            "body": JSON.stringify(datainEmailRef.current)
                        })
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

    const logout = async () => {
        signOut(auth).then(
            setTimeout(() => {
                router.reload()
                localStorage.clear()
            }, 500)
        )
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