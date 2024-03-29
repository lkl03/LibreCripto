import { useState, useEffect, useCallback } from 'react'
import Head from 'next/head'
import { useRouter } from 'next/router'
import Intro from '../../../components/Anuncio/Intro'
import Body from '../../../components/Mi Perfil/Body'
//import Navbar from '../../components/Layout/Navbar'
import Navbar from '../../../components/Layout/NavbarLogged'
import Sidebar from '../../../components/Layout/Sidebar'
import Footer from '../../../components/Layout/Footer'
import styles from '../../../styles/style'
import { menu, close } from '../../../assets/index'
import { getDoc, doc, getFirestore } from "firebase/firestore"
import { app } from '../../../config'
import { Circles } from 'react-loader-spinner'
import Loader from '../../../components/Layout/Loader'

export default function AnuncioLayout() {

  const router = useRouter();

  const [toggle, setToggle] = useState(false)

  const [active, setActive] = useState(false)

  const [anuncio, setAnuncio] = useState({})
  const [creator, setCreator] = useState({})

  const [loading, setLoading] = useState(true)

  const changeBackground = () => {
    if (window.scrollY >= 80) {
      setActive(true)
    } else {
      setActive(false)
    }
  }

  useEffect(() => {
    window.addEventListener('scroll', changeBackground)
  }, []);

  const [isLogged, setIsLogged] = useState(true)
  useEffect(() => {
    const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
    if(!userInfo) {
      setIsLogged(false)
      router.push('/acceder')
    }
  }, [])

  if (!isLogged) {
    return <div className='w-full overflow-hidden'>
          <div className={`${styles.flexStart} sm:mt-[7.5rem] mt-20`}>
            <div className={`${styles.boxWidth}`}>
              <Loader />
            </div>
          </div>
    </div>
  }

  return (
    <>
      <Head>
        <title>LibreCripto | Mi Perfil</title>
        <meta name="description" content="Accede a tu perfil de usuario en LibreCripto para poder ver tus estadísticas e información como miembro de LibreCripto." />
        <meta name="keywords" content="perfil de usuario, LibreCripto, estadisticas, informacion, criptomonedas" />
        <meta name="robots" content="index,follow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="Spanish" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="/favicon.ico" />
      </Head>
      <header>
        <div className={`fixed w-full max-w-[1920px] m-auto z-40 bg-black sidebar-shadow`}>
          <div className={`sm:px-60 px-12 ${styles.flexCenter} gap-5`}>
            <img className='xs:flex hidden w-[28px] h-[28px] object-contain cursor-pointer' onClick={() => setToggle((prev) => !prev)} src={toggle ? close.src : menu.src} alt="menu"></img>
            <Navbar />
            <img className='xs:hidden flex  w-[28px] h-[28px] object-contain cursor-pointer' onClick={() => setToggle((prev) => !prev)} src={toggle ? close.src : menu.src} alt="menu"></img>
          </div>
        </div>
        <div className={`${toggle ? 'flex' : 'hidden'} fixed h-full max-w-[1920px] m-auto z-40 bg-black sidebar-shadow`}>
          <div className={`px-5 ${styles.flexCenter}`}>
            <Sidebar />
          </div>
        </div>
      </header>
      <main>
        <div className='bg-black w-full overflow-hidden sm:[z-0]'>
          <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
            <div className={`${styles.boxWidth}`}>
              <div className='mx-auto mt-4'>
                <Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} />
              </div>
            </div>
          </div> 
          <div className={`bg-black flex flex-col justify-center items-start`}>
              <div className={`bg-orange ${styles.paddingX} ${styles.flexStart} h-[25vh] w-full`}></div>
              <div className={`${styles.paddingX} flex justify-between items-start m-auto`}>
                <div className={`${styles.boxWidth}`}>
                  <Body />
                </div>
              </div>
          </div>
          <div className={`bg-orange ${styles.paddingX} ${styles.flexStart}`}>
            <div className={`${styles.boxWidth}`}>
              <Footer />
            </div>
          </div>
        </div>
      </main>
    </>
  )
}