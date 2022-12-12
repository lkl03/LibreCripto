import { useContext, useEffect, useState } from "react"
import { logo } from '../../assets';
import styles, { layout } from '../../styles/style'
import Link from 'next/link'
import { FaArrowLeft, FaGoogle, FaFacebook, FaEye, FaEyeSlash, FaTimes } from 'react-icons/fa';
//import LoginPopup from './LoginPopup';
//import RegisterPopup from './RegisterPopup';
import { useRouter } from "next/router"
import { AppContext } from "../AppContext"

const Index = () => {

  const [showLogin, setShowLogin] = useState(false);
  const [showRegister, setShowRegister] = useState(false);
  const [eye, setEye] = useState(false);

  const changePopup = () => {
    setShowLogin(false)
    setShowRegister(true)
  }

  const [user, setUser] = useState({
    email: "",
    password: "",
  });

  const [regUser, setRegUser] = useState({
    regemail: "",
    regpass: "",
    regname: "",
  });

  const [error, setError] = useState("");
  const [regError, setRegError] = useState("");
  const [GGError, setGGError] = useState('')
  const [FBError, setFBError] = useState('')

  const router = useRouter();

  let { signup, login, loginWithGoogle, loginWithFacebook } = useContext(AppContext);

  const logHandleChange = ({ target: { name, value } }) => {
    setUser({ ...user, [name]: value });
  }

  const regHandleChange = ({ target: { name, value } }) => {
    setRegUser({ ...regUser, [name]: value });
  }

  const handleGoogleSignUp = async () => {
    try {
      await loginWithGoogle()
      router.push("/chatlogged")
    } catch {
      setGGError("Error al ingresar con Google")
    }
  }

  const handleFacebookSignUp = async () => {
    try {
      await loginWithFacebook()
      router.push("/chatlogged")
    } catch {
      setFBError("Error al ingresar con Facebook")
    }
  }

  const logHandleSubmit = async (e) => {
    setError("");
    e.preventDefault();
    !/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(user.email) && setError("Email inválido");
    if (user) {
      if (user.password.length > 5) {
        try {
          await login(user.email, user.password);
          router.push("/market")
        } catch (error) {
          error.code == `auth/wrong-password` && setError("Contraseña incorrecta")
        }
      }
    } else {
      setError("Por favor completa todos los campos")
    }
  }

  const regHandleSubmit = async (e) => {
    setRegError("");
    e.preventDefault();
    !/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i.test(regUser.regemail) && setRegError("Email inválido");
    regUser.regpass.length < 6 && setRegError("La contraseña debe tener al menos 6 caracteres");
    regUser.regname.length < 3 && setRegError("El nombre debe tener al menos 3 caracteres");
    if (regUser) {
      if (regUser.regpass.length > 5 && regUser.regname.length > 2) {
        try {
          await signup(regUser.regemail, regUser.regpass, regUser.regname);
        } catch (error) {
          error.code == `auth/email-already-in-use` && setRegError("Este email ya está en uso.")
          error.code == `auth/invalid-email` && setRegError("Email inválido")
          error.code == `auth/weak-password` && setRegError("La contraseña es muy débil")
        }
      }
    } else {
      setRegError("Por favor completa todos los campos")
    }
  }
    return (
      <div className="flex justify-start items-center flex-col h-screen">
        {/*LoginPopup*/}
        {showLogin ? <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
            <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                <FaTimes onClick={() => setShowLogin(false)} />
            </div>
            
            <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Hola de nuevo!</p>
                <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Accedé a tu cuenta con tu email y contraseña</p>
                <div className='w-full mt-5 mb-5'>
                    <form onSubmit={logHandleSubmit} className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                      <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                          <label htmlFor="email" className='text-white font-medium text-start'>Email</label>
                          <input type="email" id='email' name='email' required placeholder='Ingresá tu correo electrónico' autoComplete="email" onChange={logHandleChange} className='input p-3 text-white outline-none'></input>
                      </div>
                      <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                          <label htmlFor="pass" className='text-white font-medium text-start'>Contraseña</label>
                          <div className='flex flex-row flex-wrap w-full items-center justify-between input'>
                              <input type={eye ? 'text' : 'password'} id='password' name='password' required placeholder='Ingresá tu contraseña' autoComplete="current-password" onChange={logHandleChange} className='bg-transparent p-3 text-white outline-none sm:w-[90%] w-[75%]'></input>
                              {eye ? 
                                  <FaEyeSlash onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                                  : 
                                  <FaEye onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                              }
                          </div>
                      </div>
                        <button type='submit' className={`${layout.buttonWhite} w-[90%] mt-5`}>
                          Ingresar
                        </button>
                      <div className='text-red-600'>{error}</div>
                    </form>
                    <div className='flex flex-col flex-wrap w-full items-center justify-center gap-2 mt-5'>
                        <p className={`${layout.link} text-center cursor-pointer`}>Olvidé mi contraseña</p>
                        <p onClick={() => changePopup()} className={`${layout.link} text-center cursor-pointer text-orange hover:text-white`}>¿Aun no tenés tu cuenta? Registrate</p>
                    </div>
                </div>
            </div>
        </div> : ''}
        {/*LoginPopup*/}
        {/*RegisterPopup*/}
        {showRegister ? <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
            <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                <FaTimes onClick={() => setShowRegister(false)} />
            </div>
            
            <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Bienvenido!</p>
                <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Registrate sencillamente y accedé a tu cuenta</p>
                <div className='w-full mt-5 mb-5'>
                  <form onSubmit={regHandleSubmit} className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regemail" className='text-white font-medium text-start'>Email</label>
                        <input type="email" id='regemail' name='regemail' autoComplete="email" onChange={regHandleChange} placeholder='Ingresá tu correo electrónico' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regname" className='text-white font-medium text-start'>Nombre</label>
                        <input type="text" id='regname' name='regname' autoComplete="name" onChange={regHandleChange} placeholder='Ingresá tu nombre' className='input p-3 text-white outline-none'></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regpass" className='text-white font-medium text-start'>Contraseña</label>
                        <div className='flex flex-row flex-wrap w-full items-center justify-between input'>
                            <input type={eye ? 'text' : 'password'} id='regpass' name='regpass' autoComplete="current-password" onChange={regHandleChange} placeholder='Ingresá tu contraseña' className='bg-transparent p-3 text-white outline-none sm:w-[90%] w-[75%]'></input>
                            {eye ? 
                                <FaEyeSlash onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                                : 
                                <FaEye onClick={() => setEye((prev) => !prev)} size='20' className='text-white cursor-pointer mr-5' />
                            }
                        </div>
                    </div>
                    <div className='flex flex-row-reverse w-[90%] gap-2'>
                        <label htmlFor="regcheck" className='text-white text-start'>Estoy de acuerdo con los <Link href="/terminos-y-condiciones"><a target="_blank" className={`${layout.link} font-medium`}>Términos y Condiciones</a></Link> y acepto la <Link href="/politica-de-privacidad"><a target="_blank" className={`${layout.link} font-medium`}>Política de Privacidad</a></Link> del sitio.</label>
                        <input type="checkbox" required id='regcheck' placeholder='Ingresá tu teléfono, ej: 11-2345-6789' className='p-3 text-white outline-none'></input>
                    </div>
                    <button type='submit' className={`${layout.buttonWhite} w-[90%] mt-5`}>
                      <a>Registrarme</a>
                    </button>
                    <div className="text-red-600 font-montserrat">{regError}</div>
                  </form>
                </div>
            </div>
        </div> : ''}
        {/*RegisterPopup*/}
        <div className=" relative w-full h-full">
          <video
            src={require('../../assets/bgvideo.mp4')}
            type="video/mp4"
            loop
            controls={false}
            muted
            autoPlay
            className="w-full h-full object-cover"
            style={{filter: 'grayscale(1)'}}
          />

          <div className="absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay">
            <div className='absolute z-[0] w-[75%] h-[25%] bottom-[30%] orange__gradient' />
            <div className='absolute top-5 left-5 text-white text-4xl cursor-pointer z-[1]'>
              <Link href='/'>
                <a><FaArrowLeft /></a>
              </Link>
            </div>
            <div className="p-5 z-[1]">
              <img src={logo.src} className='sm:w-[35%] w-[65%] h-[auto] m-auto' alt='logo' />
              <div className='flex sm:flex-row flex-col flex-wrap w-full items-center justify-center gap-5 mt-5'>
                <button type='button' className={`${layout.buttonWhite} text-black hover:text-orange`}>
                  <div className='flex flex-row gap-2 items-center justify-center' onClick={handleGoogleSignUp}>
                    <FaGoogle size='25' /> Acceder con Google
                  </div>
                </button>
                <button type='button' className={`${layout.buttonWhite} bg-blue-800 hover:bg-white text-[#fff] hover:text-blue-800 transition-all duration-300 ease-in-out`}>
                  <div className='flex flex-row gap-2 items-center justify-center' onClick={handleFacebookSignUp}>
                    <FaFacebook size='25' /> Acceder con Facebook
                  </div>
                </button>
              </div>
              <div className='flex flex-col flex-wrap w-full items-center justify-center gap-2 mt-5'>
                <p className={`${layout.link} font-montserrat font-medium text-center cursor-pointer`} onClick={() => setShowLogin(true)}>Ingresar con email y contraseña</p>
              </div>
              <div className='flex flex-col flex-wrap w-full items-center justify-center mt-2'>
                <p className="font-montserrat text-red-600 text-center">{FBError}</p>
              </div>
              <div className='flex flex-col flex-wrap w-full items-center justify-center mt-2'>
                <p className="font-montserrat text-red-600 text-center">{GGError}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
};

export default Index;