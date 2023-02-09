import { useState, useEffect } from 'react'
import Head from 'next/head'
import Intro from '../../../components/Mis Anuncios/Intro'
import Anuncios from '../../../components/Mis Anuncios/Anuncios'
//import Navbar from '../../components/Layout/Navbar'
import Navbar from '../../../components/Layout/NavbarLogged'
import Sidebar from '../../../components/Layout/Sidebar'
import Footer from '../../../components/Layout/Footer'
import styles from '../../../styles/style'
import { menu, close } from '../../../assets/index'
import { useRouter } from "next/router"
import Loader from '../../../components/Layout/Loader'

export default function Market() {

    const [toggle, setToggle] = useState(false)

    const [active, setActive] = useState(false)

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

    const router = useRouter();
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
                <title>LibreCripto | Mis Anuncios</title>
                <meta name="description" content="Consultá tus anuncios de criptomonedas en un mismo lugar. Simple, rápido y seguro con LibreCripto." />
                <meta name="keywords" content="cripto, anuncios, criptomonedas, mercado cripto, LibreCripto" />
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
                        <Navbar title="Mis Anuncios" />
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
                    <div className={`bg-black ${styles.flexStart} sm:mt-[7.5rem] mt-20 sm:hidden`}>
                        <div className={`${styles.boxWidth}`}>
                            <Intro />
                        </div>
                    </div>
                    <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
                        <div className={`${styles.boxWidth}`}>
                            <Anuncios />
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