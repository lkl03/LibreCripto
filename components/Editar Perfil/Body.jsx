import { useContext, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { FaArrowLeft, FaGoogle, FaFacebook, FaEye, FaEyeSlash, FaTimes } from 'react-icons/fa';
import { FaMapMarkerAlt } from 'react-icons/fa'
import { HiStar } from 'react-icons/hi'
import { MdWarningAmber } from 'react-icons/md'
import Moment from 'react-moment';
import 'moment/locale/es';
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc, setDoc, updateDoc, deleteDoc } from "firebase/firestore"
import { app } from '../../config'
import { now } from 'moment'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import { Circles } from 'react-loader-spinner'
import { auth } from '../../config';
import { updateProfile, updateEmail, reauthenticateWithPopup, reauthenticateWithCredential, EmailAuthProvider, GoogleAuthProvider, FacebookAuthProvider, deleteUser  } from "firebase/auth";
import ImageUploading from 'react-images-uploading';
import { getStorage, ref, uploadString, getDownloadURL  } from "firebase/storage";
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import axios from "axios";
import useState from 'react-usestateref'

const Body = ({ image, userName, userEmail, userPhone, createdAt, description, totalOperations, lastOperationDate, operationsPunctuation, load, anuncios, userID, currentUser, provider }) => {
    let { user, logout, signup } = useContext(AppContext)

    const router = useRouter();

    const db = getFirestore(app);
    const storage = getStorage();
    const storageRef = ref(storage, `${userID}-new-profile-pic`);

    const [username, setUsername, usernameRef] = useState(userName)
    const [usersecret, setUsersecret, usersecretRef] = useState(userID)
    const [chatEngineID, setChatEngineID] = useState('')

    useEffect(() => {
        const userInfo = JSON.parse(localStorage.getItem('user')) || {};
        const { uid, displayName } = userInfo;
        
        const getUser = async () => {
          const itemsRef = query(collection(db, "users"), where('uid', '==', uid));
          const querySnapshot = await getDocs(itemsRef);
          let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
          console.log(data[0]);
          setUsername(data[0]?.publicID)
        };
      
        if (!uid) {
          localStorage.clear();
          return;
        }
      
        setUsername(displayName);
        setUsersecret(uid);
      
        axios
          .get('https://api.chatengine.io/users/', {
            headers: { "Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8' }
          })
          .then(function(response) {
            console.log(response);
          });
      
        axios
          .put('https://api.chatengine.io/users/', {
            username: usernameRef.current,
            secret: usersecretRef.current
          }, {
            headers: { "Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8' }
          })
          .then(function(response) {
            console.log(response.data.id);
            setChatEngineID(response.data.id);
          });
      
        getUser();
      }, [router.isReady]);

    const imageSuccess = () => toast.success("Imagen actualizada correctamente");
    const imageError = (e) => toast.error("No se pudo actualizar la imagen:", e)
    const infoSuccess = () => toast.success("Información actualizada correctamente");
    const infoError = (e) => toast.error("No se pudo actualizar la información:", e)
    const deletingSuccess = () => toast.success("Cuenta eliminada exitosamente");
    const deletingError = (e) => toast.error("Hubo un problema intentando eliminar tu cuenta:", e)

    const [deleteAccountMode, setDeleteAccountMode] = useState(false)
    const [insertPassword, setInsertPassword] = useState(false)
    const [modifyEmail, setModifyEmail] = useState(false)


    const [images, setImages] = useState([]);
    const maxNumber = 1;

    const onChange = (imageList, addUpdateIndex) => {
        // data for submit
        console.log(imageList, addUpdateIndex);
        setImages(imageList);
    };

    const [regUser, setRegUser] = useState({
        regemail: "",
        regname: "",
        regphone: "",
        regdesc: "",
        regimage: ""
    });

    const [passwordUser, setPasswordUser] = useState({
        passwordconfirm: ""
    });

    const [passwordEmail, setPasswordEmail] = useState({
        passwordmodifyemail: ""
    });

    const [regError, setRegError] = useState("");

    const regHandleChange = ({ target: { name, value } }) => {
        setRegUser({ ...regUser, [name]: value });
    }

    const passwordConfirmChange = ({ target: { name, value } }) => {
        setPasswordUser({ ...passwordUser, [name]: value });
    }

    const passwordEmailChange = ({ target: { name, value } }) => {
        setPasswordEmail({ ...passwordUser, [name]: value });
    }

    const confirmPasswordSubmit = async (e) => {
        e.preventDefault(); 
        console.log(passwordUser)
        const credential = EmailAuthProvider.credential(
            userEmail,
            passwordUser.passwordconfirm
        )
        reauthenticateWithCredential(currentUser, credential).then(() => {
            deleteUser(currentUser).then(() => {
                deletingSuccess()
                try {
                    deleteDoc(doc(db, "users", userID))
                    axios.delete(
                        `https://api.chatengine.io/users/${chatEngineID}`,
                        {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
                    )
                }
                catch (e) {
                    deletingError(e)
                    console.log("Error getting cached document:", e);
                }
                setTimeout(() => {
                    localStorage.clear()
                    router.push("/acceder")
                }, 3000)
              }).catch((e) => {
                deletingError(e)
            });
        }).catch((error) => {
            deletingError(error)
        });
    }

    const confirmModifyEmailSubmit = async (e) => {
        e.preventDefault(); 
        console.log(passwordEmail)
        const credential = EmailAuthProvider.credential(
            userEmail,
            passwordEmail.passwordmodifyemail
        )
        reauthenticateWithCredential(currentUser, credential).then(() => {
            try {
                updateDoc(doc(db, "users", userID), {
                    name: user.displayName,
                    email: regUser.regemail,
                    phone: user.phoneNumber,
                    image: user?.photoURL,
                    desc: description
                })
                updateEmail(currentUser, regUser.regemail)
                localStorage.setItem('user', JSON.stringify(user));
                infoSuccess()
                setTimeout(() => {
                    router.push("/market/mi-perfil")
                }, 3000)
            }
            catch (e) {
                infoError(e)
                console.log("Error getting cached document:", e);
            }
        }).catch((error) => {
            infoError(error)
        });
    }

    const newImage = (value) => {
        setRegUser({regimage: value})
        try {
            const newProfilePic = value;
            uploadString(storageRef, newProfilePic, 'data_url').then((snapshot) => {
                getDownloadURL(ref(storage, `${userID}-new-profile-pic`)).then((url) => {
                    updateDoc(doc(db, "users", userID), {
                        image: url
                    })
                    updateProfile(currentUser, {
                        photoURL: url
                    })
                  })
                  .catch((error) => {
                    imageError(error)
                  });
            });
            localStorage.setItem('user', JSON.stringify(user));
            imageSuccess()
            setTimeout(() => {
                router.push("/market/mi-perfil")
            }, 3000)
        }
        catch (e) {
            imageError(e)
            console.error("Error getting cached document:", e);
        }
    }

    const regHandleSubmit = async (e) => {
        setRegError("");
        e.preventDefault();
        if (regUser.regemail !== '' && regUser.regname == '' && regUser.regphone == '' && regUser.regdesc == '') {
            console.log(regUser.regemail, regUser.regname, regUser.regphone, regUser.regdesc)
            if(provider == "google.com") {
                let newProvider = new GoogleAuthProvider()
                reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                    // The firebase.User instance:
                    let credential = result.user.accessToken
                    console.log(credential)
                    try {
                        updateDoc(doc(db, "users", userID), {
                            name: user.displayName,
                            email: regUser.regemail,
                            phone: user.phoneNumber,
                            image: user?.photoURL,
                            desc: description
                        })
                        updateEmail(currentUser, regUser.regemail)
                        localStorage.setItem('user', JSON.stringify(user));
                        infoSuccess()
                        setTimeout(() => {
                            router.push("/market/mi-perfil")
                        }, 3000)
                    }
                    catch (e) {
                        infoError(e)
                        console.log("Error getting cached document:", e);
                    }
                  }, function(error) {
                    infoError(e)
                    console.log(error)
                });
            } else if (provider== "password") {
                setModifyEmail(true)
            } else if (provider== "facebook.com") {
                let newProvider = new FacebookAuthProvider()
                reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                    // The firebase.User instance:
                    let credential = result.user.accessToken
                    console.log(credential)
                    try {
                        updateDoc(doc(db, "users", userID), {
                            name: user.displayName,
                            email: regUser.regemail,
                            phone: user.phoneNumber,
                            image: user?.photoURL,
                            desc: description
                        })
                        updateEmail(currentUser, regUser.regemail)
                        localStorage.setItem('user', JSON.stringify(user));
                        infoSuccess()
                        setTimeout(() => {
                            router.push("/market/mi-perfil")
                        }, 3000)
                    }
                    catch (e) {
                        infoError(e)
                        console.log("Error getting cached document:", e);
                    }
                  }, function(error) {
                    infoError(e)
                    console.log(error)
                });
            } else {
                console.log("mmm")
            }
        } else if (regUser.regemail == '' && regUser.regname !== '' && regUser.regphone == '' && regUser.regdesc == '') {
            console.log(regUser.regemail, regUser.regname, regUser.regphone, regUser.regdesc)
            try {
                updateDoc(doc(db, "users", userID), {
                    name: regUser.regname,
                    email: user.email,
                    phone: user.phoneNumber,
                    image: user?.photoURL,
                    desc: description
                })
                updateProfile(currentUser, {
                    displayName: regUser.regname
                })
                infoSuccess()
                setTimeout(() => {
                    router.push("/market/mi-perfil")
                }, 3000)
                localStorage.setItem('user', JSON.stringify(user));
            }
            catch (e) {
                infoError(e)
                console.log("Error getting cached document:", e);
            }
        } else if (regUser.regemail == '' && regUser.regname == '' && regUser.regphone !== '' && regUser.regdesc == '') {
            console.log(regUser.regemail, regUser.regname, regUser.regphone, regUser.regdesc)
            try {
                updateDoc(doc(db, "users", userID), {
                    name: user.displayName,
                    email: user.email,
                    phone: regUser.regphone,
                    image: user?.photoURL,
                    desc: description
                })
                infoSuccess()
                setTimeout(() => {
                    router.push("/market/mi-perfil")
                }, 3000)
                localStorage.setItem('user', JSON.stringify(user));
            }
            catch (e) {
                infoError(e)
                console.log("Error getting cached document:", e);
            }
        } else if (regUser.regemail !== '' || regUser.regname !== '' || regUser.regphone !== '' || regUser.regdesc !== '') {
            console.log(regUser.regemail, regUser.regname, regUser.regphone, regUser.regdesc)
            if(provider == "google.com") {
                let newProvider = new GoogleAuthProvider()
                reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                    // The firebase.User instance:
                    let credential = result.user.accessToken
                    console.log(credential)
                    try {
                        updateDoc(doc(db, "users", userID), {
                            name: user.displayName,
                            email: regUser.regemail,
                            phone: user.phoneNumber,
                            image: user?.photoURL,
                            desc: description
                        })
                        updateEmail(currentUser, regUser.regemail)
                        localStorage.setItem('user', JSON.stringify(user));
                        infoSuccess()
                        setTimeout(() => {
                            router.push("/market/mi-perfil")
                        }, 3000)
                    }
                    catch (e) {
                        infoError(e)
                        console.log("Error getting cached document:", e);
                    }
                  }, function(error) {
                    infoError(e)
                    console.log(error)
                });
            } else if (provider== "password") {
                setModifyEmail(true)
            } else if (provider== "facebook.com") {
                let newProvider = new FacebookAuthProvider()
                reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                    // The firebase.User instance:
                    let credential = result.user.accessToken
                    console.log(credential)
                    try {
                        updateDoc(doc(db, "users", userID), {
                            name: regUser.regname,
                            email: regUser.regemail,
                            phone: regUser.regphone,
                            image: user?.photoURL,
                            desc: regUser.regdesc
                        })
                        updateEmail(currentUser, regUser.regemail)
                        localStorage.setItem('user', JSON.stringify(user));
                        infoSuccess()
                        setTimeout(() => {
                            router.push("/market/mi-perfil")
                        }, 3000)
                    }
                    catch (e) {
                        infoError(e)
                        console.log("Error getting cached document:", e);
                    }
                  }, function(error) {
                    infoError(e)
                    console.log(error)
                });
            } else {
                console.log("mmm")
            }
        } else if (regUser.regemail == '' && regUser.regname == '' && regUser.regphone == '' && regUser.regdesc !== '') {
            console.log(regUser.regemail, regUser.regname, regUser.regphone, regUser.regdesc)
            try {
                updateDoc(doc(db, "users", userID), {
                    name: user.displayName,
                    email: user.email,
                    phone: user.phoneNumber,
                    image: user?.photoURL,
                    desc: regUser.regdesc
                })
                infoSuccess()
                setTimeout(() => {
                    router.push("/market/mi-perfil")
                }, 3000)
                localStorage.setItem('user', JSON.stringify(user));
            }
            catch (e) {
                infoError(e)
                console.log("Error getting cached document:", e);
            }
        }
        else if (regUser.regemail == '' && regUser.regname == '' && regUser.regphone == '' && regUser.regdesc == '') {
            {/*setRegError("¡No modificaste ningún campo!")*/}
            setRegUser({
                regemail: userEmail,
                regname: userName,
                regphone: userPhone,
                regdesc: description
            })
        }
    }

    const deleteUserInfo = () => {
        if (provider == "google.com") {
            let newProvider = new GoogleAuthProvider()
            reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                // The firebase.User instance:
                let credential = result.user.accessToken
                console.log(credential)
                deleteUser(currentUser).then(() => {
                    deletingSuccess()
                    try {
                        deleteDoc(doc(db, "users", userID))
                        axios.delete(
                            `https://api.chatengine.io/users/${chatEngineID}`,
                            {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
                        )
                    }
                    catch (e) {
                        deletingError(e)
                        console.log("Error getting cached document:", e);
                    }
                    setTimeout(() => {
                        localStorage.clear()
                        router.push("/acceder")
                    }, 3000)
                  }).catch((e) => {
                    deletingError(e)
                });
              }, function(error) {
                deletingError(error)
                console.log(error)
            });
        } else if (provider== "password") {
            setInsertPassword(true)
        } else if (provider== "facebook.com") {
            let newProvider = new FacebookAuthProvider()
            reauthenticateWithPopup(currentUser, newProvider).then(function(result) {
                // The firebase.User instance:
                let credential = result.user.accessToken
                console.log(credential)
                deleteUser(currentUser).then(() => {
                    deletingSuccess()
                    try {
                        deleteDoc(doc(db, "users", userID))
                        axios.delete(
                            `https://api.chatengine.io/users/${chatEngineID}`,
                            {headers: {"Private-key": '07707db6-68e3-40c0-b17c-b71a74c742d8'}}
                        )
                    }
                    catch (e) {
                        deletingError(e)
                        console.log("Error getting cached document:", e);
                    }
                    setTimeout(() => {
                        localStorage.clear()
                        router.push("/acceder")
                    }, 3000)
                  }).catch((e) => {
                    deletingError(e)
                });
              }, function(error) {
                deletingError(error)
                console.log(error)
            });
        } else {
            console.log("mmm")
        }
    }

    const closeAllPopups = () => {
        setDeleteAccountMode(false)
        setInsertPassword(false)
    }

    return (
        <section id='perfil' className={`w-full flex md:flex-col flex-col sm:pb-12 pb-6 xs:mt-20`}>
            <ToastContainer />
            <div className={`flex md:flex-row flex-col flex-wrap justify-between mb-5`}>
                <div className={`flex flex-col w-full ${styles.paddingY}`}>
                    <div className='flex flex-wrap justify-center items-center'>
                        <div className={`flex flex-wrap flex-col justify-center items-center mt-5`}>
                            <div className="rounded-full md:h-60 md:w-60 ss:h-40 ss:w-40 h-20 w-20 profile-icon">
                                <img referrerPolicy="no-referrer" className='rounded-full w-full h-auto' src={image && image !== null ? image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="profile-icon" />
                            </div>
                            <div className='mt-4'>
                                <ImageUploading
                                    multiple
                                    value={images}
                                    onChange={onChange}
                                    maxNumber={maxNumber}
                                    dataURLKey="data_url"
                                    maxFileSize={5000000}
                                    acceptType={['jpg', '.jpeg', 'png']}
                                >
                                    {({
                                        imageList,
                                        onImageUpload,
                                        onImageRemoveAll,
                                        onImageUpdate,
                                        onImageRemove,
                                        isDragging,
                                        dragProps,
                                        errors
                                    }) => (
                                        // write your building UI
                                        <div className="flex flex-wrap justify-center items-center flex-col upload__image-wrapper">
                                            <button 
                                                className='text-white font-medium'
                                                style={isDragging ? { color: '#fe9416' } : undefined}
                                                onClick={onImageUpload}
                                                {...dragProps}
                                            >
                                                Modificar imagen de perfil
                                            </button>
                                            &nbsp;
                                            {/*<button onClick={onImageRemoveAll}>Remove all images</button>*/}
                                            {imageList.map((image, index) => (
                                                <div key={index} className="flex flex-wrap flex-col justify-center items-center image-item">
                                                    <img src={image['data_url']} alt="new-profile-pic" className='rounded-full w-[125px] h-[125px]' />
                                                    <div className="flex flex-wrap gap-5 image-item__btn-wrapper mt-2">
                                                        <button className='text-orange font-medium text-start' onClick={() => newImage(image['data_url'])}>Confirmar</button>
                                                        <button className='text-white font-medium text-start' onClick={() => onImageUpdate(index)}>Elegir otra imagen</button>
                                                        <button className='text-red-500 font-medium text-start' onClick={() => onImageRemove(index)}>Cancelar</button>
                                                    </div>
                                                    <p className='text-gray-500 mt-2 italic'>Tamaño de imagen máximo 5mb, formatos aceptados: .jpg, .jpeg, .png</p>
                                                </div>
                                            ))}
                                            {(
                                                imageList && errors && 
                                                <div className='text-yellow-400'>
                                                    {errors.maxNumber && <span>Únicamente se permite subir una imagen</span>}
                                                    {errors.acceptType && <span>El formato de la imagen seleccionada no está permitido</span>}
                                                    {errors.maxFileSize && <span>El tamaño de la imagen seleccionada supera los 5mb</span>}
                                                </div>
                                            )}
                                        </div>
                                    )}
                                </ImageUploading>
                            </div>
                        </div>
                    </div>
                </div>
                <div className='flex flex-wrap md:w-[100%] w-[100%] justify-start items-start'>
                    <form onSubmit={regHandleSubmit} className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regname" className='text-white font-medium text-start'>Nombre</label>
                            <input type="text" id='regname' name='regname' autoComplete="name" onChange={regHandleChange} defaultValue={userName} className='input p-3 text-white outline-none'></input>
                        </div>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regemail" className='text-white font-medium text-start'>Email</label>
                            <input type="email" id='regemail' name='regemail' autoComplete="email" onChange={regHandleChange} defaultValue={userEmail} className='input p-3 text-white outline-none'></input>
                        </div>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regphone" className='text-white font-medium text-start'>Teléfono</label>
                            <input type="text" id='regphone' name='regphone' autoComplete="phone" onChange={regHandleChange} defaultValue={userPhone} className='input p-3 text-white outline-none'></input>
                        </div>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regdesc" className='text-white font-medium text-start'>Descripción</label>
                            <textarea id='regdesc' name='regdesc' autoComplete="desc" onChange={regHandleChange} maxLength={460} defaultValue={description} className='input p-3 text-white outline-none'></textarea>
                        </div>
                        {/*<div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regpass" className='text-white font-medium text-start'>Contraseña</label>
                        <div className='flex flex-row flex-wrap w-full items-center justify-between input'>
                            <input type={eye ? 'text' : 'password'} id='regpass' name='regpass' autoComplete="current-password" onChange={regHandleChange} placeholder='Ingresá tu contraseña' className='bg-transparent p-3 text-white outline-none sm:w-[90%] w-[75%]'></input>
                            {eye ? 
                                <FaEyeSlash onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                                : 
                                <FaEye onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                            }
                        </div>
                    </div>*/}
                    <div className='flex flex-wrap justify-center items-center w-full gap-20'>
                        <button type='submit' className={`${layout.buttonWhite} w-[25%] py-[1rem] mt-5`}>
                            <a>Actualizar información</a>
                        </button>
                        <Link href='/market/mi-perfil'>
                            <a className={`px-8 bg-orange text-white text-center cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[25%] py-[1rem] mt-5`}>
                                Volver a Mi Perfil
                            </a>
                        </Link>
                    </div>
                    <button type='button' onClick={() => setDeleteAccountMode(true)} className={`px-8 bg-red-500 text-white cursor-pointer hover:bg-red-600 rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[25%] py-[1rem] mt-5`}>
                            <a>Eliminar mi cuenta</a>
                    </button>
                    {deleteAccountMode ? <div>
                        <p className='text-white font-montserrat'>¿Seguro querés eliminar tu cuenta? Esta acción es irreversible.</p>
                        <div className='flex flex-wrap justify-center items-center w-full gap-5'>
                        <button type='button' onClick={() => deleteUserInfo()} className={`px-8 bg-orange text-white cursor-pointer hover:bg-red-600 rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                            <a>Sí, eliminar</a>
                        </button>
                        <button type='button' onClick={() => closeAllPopups()} className={`px-8 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                            <a>No, volver</a>
                        </button>
                        </div>
                    </div> : ''}
                    <div className="text-red-600 font-montserrat">{regError}</div>
                    </form>
                    {insertPassword ?
                    <div className='flex flex-wrap md:w-[100%] w-[100%] justify-start items-start'>
                    <form onSubmit={confirmPasswordSubmit} className='flex flex-wrap w-full items-center justify-center mb-5 gap-5'>
                        <input type="password" id='passwordconfirm' name='passwordconfirm' autoComplete="password" onChange={passwordConfirmChange} placeholder='Ingresá tu contraseña' className='input p-3 text-white outline-none text-center'></input>
                        <button type='submit' className={`${layout.buttonWhite} py-[0.5rem]`}>
                            <a>Confirmar</a>
                        </button>
                    </form>
                    </div>
                    : ''}
                    {modifyEmail ?
                    <div className='flex flex-wrap md:w-[100%] w-[100%] justify-start items-start'>
                    <form onSubmit={confirmModifyEmailSubmit} className='flex flex-wrap w-full items-center justify-center mb-5 gap-5'>
                        <input type="password" id='passwordmodifyemail' name='passwordmodifyemail' autoComplete="password" onChange={passwordEmailChange} placeholder='Ingresá tu contraseña' className='input p-3 text-white outline-none text-center'></input>
                        <button type='submit' className={`${layout.buttonWhite} py-[0.5rem]`}>
                            <a>Confirmar</a>
                        </button>
                    </form>
                    </div>
                    : ''}
                </div>
            </div>
            <div>
            </div>
        </section>
    )
}

export default Body