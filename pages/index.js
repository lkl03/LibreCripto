import { useState, useEffect, useContext } from 'react'
import Head from 'next/head'
import Hero from '../components/Index/Hero'
import Welcome from '../components/Index/Welcome'
import StepAhead from '../components/Index/StepAhead'
import Future from '../components/Index/Future'
import Navbar from '../components/Layout/Navbar'
//import Navbar from '../components/Layout/NavbarLogged'
import Footer from '../components/Layout/Footer'
import Faq from '../components/Index/Faq'
import Cta from '../components/Index/Cta'
import styles from '../styles/style'
import { AppContext } from '../components/AppContext'
import { useRouter } from "next/router"
import Loader from '../components/Layout/Loader'

export default function Home() {

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
  const [isLogged, setIsLogged] = useState(false)
  useEffect(() => {
    const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
    if(userInfo) {
      setIsLogged(true)
      router.push('/market')
    }
  }, [])

  if (isLogged) {
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
        <title>LibreCripto | Inicio</title>
        <meta name="description" content="Decile hola al mundo cripto. Comerciá tus criptomonedas por P2P y F2F de la manera más simple, rápida y segura." />
        <meta name="keywords" content="cripto, p2p, f2f" />
        <meta name="robots" content="index,follow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="Spanish" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="/favicon.ico" />
      </Head>
      <header className={`fixed w-full max-w-[1920px] m-auto z-40 ${active ? 'bg-black' : 'bg-transparent'}`}>
        <div className={`sm:px-60 px-12 ${styles.flexCenter}`}>
          <Navbar />
        </div>
      </header>
      <main>
        <div className='bg-black w-full overflow-hidden'>
          <div className={`bg-black ${styles.flexStart} sm:mt-[7.5rem] mt-20`}>
            <div className={`${styles.boxWidth}`}>
              <Hero />
            </div>
          </div>
          <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
            <div className={`${styles.boxWidth}`}>
              <Welcome />
              <StepAhead />
            </div>
          </div>
        </div>
        <div className='bg-black w-full overflow-hidden'>
          <div className={`bg-black ${styles.flexStart}`}>
            <div className={`w-[100%]`}>
              <Future />
            </div>
          </div>
          <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
            <div className={`${styles.boxWidth}`}>
              <Faq />
            </div>
          </div>
          <div className={`bg-black ${styles.flexStart}`}>
            <div className={`w-[100%] xl:max-w-[1920px]`}>
              <Cta />
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
