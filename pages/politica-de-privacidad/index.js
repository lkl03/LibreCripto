import { useState, useEffect } from 'react'
import Head from 'next/head'
import Intro from '../../components/Privacidad/Intro'
import Content from '../../components/Privacidad/Content'
import Navbar from '../../components/Layout/Navbar'
import Footer from '../../components/Layout/Footer'
import styles from '../../styles/style'
import { useRouter } from "next/router"
import Loader from '../../components/Layout/Loader'

export default function Privacidad() {

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
        <title>LibreCripto | Política de Privacidad</title>
        <meta name="description" content="Cómo protegemos la privacidad de nuestros usuarios manejando sus datos personales en cumplimiento con la ley." />
        <meta name="keywords" content="LibreCripto, políticas de privacidad, protección, privacidad, datos personales, ley" />
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
        <div className='bg-black w-full overflow-hidden sm:[z-0]'>
          <div className={`bg-black ${styles.flexStart} sm:mt-[7.5rem] mt-20`}>
            <div className={`${styles.boxWidth}`}>
              <Intro />
            </div>
          </div>
          <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
            <div className={`${styles.boxWidth}`}>
              <Content />
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