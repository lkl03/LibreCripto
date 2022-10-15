import React, { useState } from 'react'
import styles, { layout } from '../../styles/style'
import { FaEye, FaEyeSlash, FaTimes } from 'react-icons/fa'
import Link from 'next/link'

const RegisterPopup = () => {

    const [eye, setEye] = useState(false);
    const [hide, setHide] = useState(false);
  
    return (
    <div>
        {hide ? '' : 
        <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
            <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                <FaTimes /*onClick={() => setShowRegister(false)}*/ />
            </div>
            
            <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Bienvenido!</p>
                <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Registrate sencillamente y accedé a tu cuenta</p>
                <div className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regemail" className='text-white font-medium text-start'>Email</label>
                        <input type="text" id='regemail' placeholder='Ingresá tu correo electrónico' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regname" className='text-white font-medium text-start'>Nombre</label>
                        <input type="text" id='regname' placeholder='Ingresá tu nombre' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regphone" className='text-white font-medium text-start'>Teléfono</label>
                        <input type="text" id='regphone' placeholder='Ingresá tu teléfono, ej: 11-2345-6789' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regpass" className='text-white font-medium text-start'>Contraseña</label>
                        <div className='flex flex-row flex-wrap w-full items-center justify-between input'>
                            <input type={eye ? 'text' : 'password'} id='regpass' placeholder='Ingresá tu contraseña' className='bg-transparent p-3 text-white outline-none sm:w-[90%] w-[75%]'></input>
                            {eye ? 
                                <FaEyeSlash onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                                : 
                                <FaEye onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                            }
                        </div>
                    </div>
                    <div className='flex flex-row-reverse w-[90%] gap-2'>
                        <label htmlFor="regcheck" className='text-white text-start'>Estoy de acuerdo con los <Link href="/terminos-y-condiciones"><a target="_blank" className={`${layout.link} font-medium`}>Términos y Condiciones</a></Link> y acepto la <Link href="/politica-de-privacidad"><a target="_blank" className={`${layout.link} font-medium`}>Política de Privacidad</a></Link> del sitio.</label>
                        <input type="checkbox" id='regcheck' placeholder='Ingresá tu teléfono, ej: 11-2345-6789' className='p-3 text-white outline-none'></input>
                    </div>
                    <button typeof='button' className={`${layout.buttonWhite} w-[90%] mt-5`}>
                        <Link href='/'>
                            <a>Registrarme</a>
                        </Link>
                    </button>
                </div>
            </div>
        </div>
        }
    </div>
  )
}

export default RegisterPopup