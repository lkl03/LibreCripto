import { useState, useEffect } from 'react'
import Head from 'next/head'
import Intro from '../../components/Terminos/Intro'
import Content from '../../components/Terminos/Content'
import Navbar from '../../components/Layout/Navbar'
import Footer from '../../components/Layout/Footer'
import styles from '../../styles/style'

export default function Terminos() {

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
        <title>LibreCripto | Términos y condiciones</title>
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