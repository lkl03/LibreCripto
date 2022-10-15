import { useState, useEffect } from 'react'
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

  return (
    <>
      <Head>
        <title>LibreCripto | Pasar de efectivo a cripto nunca había sido tan fácil</title>
        <meta name="description" content="Generated by create next app" />
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