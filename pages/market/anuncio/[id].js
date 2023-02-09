import { useState, useEffect, useCallback } from 'react'
import Head from 'next/head'
import { useRouter } from 'next/router'
import Intro from '../../../components/Anuncio/Intro'
import Anuncio from '../../../components/Anuncio/Anuncio'
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

  const { pid } = router.query
  const anuncioId = router.query.id
  
  const db = getFirestore(app);
  useEffect(() => {
    const getAnuncio = async () => {
      try {
        const query = router.query.id
        const docRef = doc(db, "anuncios", query);
        const docSnap = await getDoc(docRef);
        console.log("Document data:", docSnap.data());
        const creatorUid = docSnap.data().createdBy
        const creatorDocs = await getDoc(doc(db, 'users', creatorUid))
        const creator = creatorDocs.data().name
        console.log(creator)
        setAnuncio(docSnap.data())
        setCreator(creatorDocs.data())
        setLoading(false)
      } catch (e) {
        console.log(e)
      }
    }
    getAnuncio()
  }, [router.isReady])

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
        <title>LibreCripto | Anuncio de {creator.name}</title>
        <meta name="description" content="Revisá el anuncio de este usuario y contactalo en caso de que desees iniciar una operación. Simple, rápido y seguro con LibreCripto." />
        <meta name="keywords" content="cripto, p2p, f2f, anuncio, mercado cripto, LibreCripto" />
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
          <div className={`bg-black ${styles.paddingX} ${styles.flexStart}`}>
              <div className={`${styles.boxWidth}`}>
                {loading ? 
                <div className='h-screen flex items-center justify-center'>
                  <div className='m-auto w-[25%] flex flex-wrap flex-col items-center justify-center'>
                    <Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /> 
                    <p className='text-white mt-5'>Cargando información del anuncio...</p>
                  </div>
                </div>
                :
                <Anuncio
                  image={creator.image}
                  status={anuncio.status}
                  anuncioID={router.query.id}
                  userName={creator.name}
                  userEmail={creator.email}
                  phone={creator.phone}
                  createdAt={anuncio.createdAt}
                  createdBy={anuncio.createdBy}
                  totalOperations={creator.totalOperations}
                  lastOperationDate={creator.lastOperationDate}
                  operationsPunctuation={creator.operationsPunctuation}
                  publisher={creator.uid}
                  publisherPublicID={creator.publicID}
                  lat={anuncio.location?.[0]}
                  lng={anuncio.location?.[1]}
                  compra={anuncio.compra}
                  venta={anuncio.venta}
                  amount={anuncio.amount}
                  currency={anuncio.currency}
                  P2P={anuncio.P2P}
                  F2F={anuncio.F2F}
                  fee={anuncio.fee}
                />}
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