import { useEffect, useState } from 'react'
import Head from 'next/head'
import Index from '../../components/Acceder/Index'
import Navbar from '../../components/Layout/Navbar'
import Footer from '../../components/Layout/Footer'
import styles from '../../styles/style'
import { logo } from '../../assets'
import { useRouter } from "next/router"
import Loader from '../../components/Layout/Loader'

export default function Ayuda() {
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
    <div className='bg-black w-full overflow-hidden sm:[z-0]'>
      <Head>
        <title>LibreCripto | Acceder</title>
        <meta name="description" content="Accede a tu cuenta de usuario y comienza a comerciar tus criptomonedas de la manera más simple, rápida y segura." />
        <meta name="keywords" content="acceder, criptomonedas, comercio, seguro" />
        <meta name="robots" content="index,follow" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="Spanish" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="/favicon.ico" />
      </Head>
        <div>
            <Index />
        </div>
    </div>
  )
}