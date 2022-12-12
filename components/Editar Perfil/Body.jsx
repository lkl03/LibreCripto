import { useContext, useState, useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { FaArrowLeft, FaGoogle, FaFacebook, FaEye, FaEyeSlash, FaTimes } from 'react-icons/fa';
import { FaMapMarkerAlt } from 'react-icons/fa'
import { HiStar } from 'react-icons/hi'
import { MdWarningAmber } from 'react-icons/md'
import Moment from 'react-moment';
import 'moment/locale/es';
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc, setDoc, updateDoc } from "firebase/firestore"
import { app } from '../../config'
import { now } from 'moment'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import { Circles } from 'react-loader-spinner'
import { auth } from '../../config';


const Body = ({image, userName, userEmail, userPhone, createdAt, description, totalOperations, lastOperationDate, operationsPunctuation, load, anuncios, userID}) => {
    let { user, logout, signup } = useContext(AppContext)

    const db = getFirestore(app);

    const [regUser, setRegUser] = useState({
        regemail: "",
        regname: "",
        regphone: ""
    });

    const [regError, setRegError] = useState("");

    const regHandleChange = ({ target: { name, value } }) => {
        setRegUser({ ...regUser, [name]: value });
    }

    const regHandleSubmit = async (e) => {
        setRegError("");
        e.preventDefault();
        if (regUser) {
            try {
              await signup(regUser.regemail, regUser.regname, regUser.regphone);
                setDoc(collection(db, "users", userID), {
                    email: regUser.regemail,
                    name: regUser.regname,
                    phone: regUser.regphone
                })
            } catch (error) {
              setRegError(error)
            }
        } else {
          setRegError("Por favor completa todos los campos")
        }
      }

    return (
        <section id='perfil' className={`w-full flex md:flex-col flex-col sm:pb-12 pb-6 xs:mt-20`}>
            <div className={`flex md:flex-row flex-col flex-wrap justify-between mb-5`}>
                <div className={`flex flex-col w-full ${styles.paddingY}`}>
                    <div className='flex flex-wrap justify-center items-center'>
                        <div className={`flex flex-wrap flex-col justify-center items-center mt-5`}>
                            <div className="rounded-full md:h-60 md:w-60 ss:h-40 ss:w-40 h-20 w-20 profile-icon">
                                <img className='rounded-full w-full h-auto' src={image && image !== null ? image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="profile-icon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div className='flex flex-wrap md:w-[100%] w-[100%] justify-start items-start'>
                <form onSubmit={regHandleSubmit} className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regname" className='text-white font-medium text-start'>Nombre</label>
                        <input type="text" id='regname' name='regname' autoComplete="name" onChange={regHandleChange} placeholder={userName} className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regemail" className='text-white font-medium text-start'>Email</label>
                        <input type="email" id='regemail' name='regemail' autoComplete="email" onChange={regHandleChange} placeholder={userEmail} className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regphone" className='text-white font-medium text-start'>Teléfono</label>
                        <input type="text" id='regphone' name='regphone' autoComplete="phone" onChange={regHandleChange} placeholder={userPhone} className='input p-3 text-white outline-none'></input>
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
                    <button type='submit' className={`${layout.buttonWhite} w-[25%] py-[1rem] mt-5`}>
                      <a>Actualizar información</a>
                    </button>
                    <div className="text-red-600 font-montserrat">{regError}</div>
                  </form>
                </div>
            </div>
        </section>
    )
}

export default Body