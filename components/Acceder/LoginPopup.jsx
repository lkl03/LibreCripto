import React, { useState } from 'react'
import styles, { layout } from '../../styles/style'
import { FaEye, FaEyeSlash, FaTimes } from 'react-icons/fa'
import Link from 'next/link'

const LoginPopup = () => {

    const [eye, setEye] = useState(false);
    const [hide, setHide] = useState(false);
  
    return (
    <div>
        {hide ? '' : 
        <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
            <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                <FaTimes onClick={() => setShowLogin(false)} />
            </div>
            
            <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Hola de nuevo!</p>
                <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Accedé a tu cuenta con tu email y contraseña</p>
                <div className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="email" className='text-white font-medium text-start'>Email</label>
                        <input type="text" id='email' placeholder='Ingresá tu correo electrónico' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="pass" className='text-white font-medium text-start'>Contraseña</label>
                        <div className='flex flex-row flex-wrap w-full items-center justify-between input'>
                            <input type={eye ? 'text' : 'password'} id='pass' placeholder='Ingresá tu contraseña' className='bg-transparent p-3 text-white outline-none sm:w-[90%] w-[75%]'></input>
                            {eye ? 
                                <FaEyeSlash onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                                : 
                                <FaEye onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                            }
                        </div>
                    </div>
                    <button typeof='button' className={`${layout.buttonWhite} w-[90%] mt-5`}>
                        <Link href='/'>
                            <a>Ingresar</a>
                        </Link>
                    </button>
                    <div className='flex flex-col flex-wrap w-full items-center justify-center gap-2 mt-5'>
                        <p className={`${layout.link} text-center cursor-pointer`}>Olvidé mi contraseña</p>
                        <p className={`${layout.link} text-center cursor-pointer`}>¿Aun no tenés tu cuenta? Registrate</p>
                    </div>
                </div>
            </div>
        </div>
        }
    </div>
  )
}

export default LoginPopup