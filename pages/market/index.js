import { useState, useEffect } from 'react'
import Head from 'next/head'
import Intro from '../../components/Market/Intro'
import Anuncios from '../../components/Market/Anuncios'
//import Navbar from '../../components/Layout/Navbar'
import Navbar from '../../components/Layout/NavbarLogged'
import Sidebar from '../../components/Layout/Sidebar'
import Footer from '../../components/Layout/Footer'
import styles from '../../styles/style'
import {menu, close} from '../../assets/index'
import { useRouter } from "next/router"
import Loader from '../../components/Layout/Loader'

//export async function getServerSideProps() {
  //const apiKey = process.env.NEXT_PUBLIC_NEWS_KEY
  //let url = 'https://newsapi.org/v2/everything?' +
  //'q=Crypto&' +
  //'language=es' +
  //'sortBy=popularity&' +
  //'apiKey=${apiKey}'
  //const apiResponse = await fetch(
      //`https://newsapi.org/v2/everything?q=criptomonedas&language=es&pageSize=5&sortBy=publishedAt&apiKey=${apiKey}`,
      //{
          //headers: {
              //Authorization: `Bearer ${process.env.NEXT_PUBLIC_NEWS_KEY}`
          //}
      //}
  //)

  //const apiJson = await apiResponse.json()

  //const { articles } = apiJson

  //return {
      //props: {
          //articles,
      //}
  //}

//}

export default function Market (articles) {

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
        <title>LibreCripto | Mercado Cripto</title>
        <meta name="description" content="Explora diferentes anuncios de compra y venta de criptomonedas en LibreCripto. Comerciá de la forma más simple, rápida y segura." />
        <meta name="keywords" content="LibreCripto, mercado cripto, criptomonedas, tendencias, comercio seguro, sencillo" />
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
                <Navbar title="Mercado Cripto" />
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
              <Anuncios 
              articles={articles}
              />
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