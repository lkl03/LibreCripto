import { useEffect, useCallback } from 'react'
import Head from 'next/head'
import { useRouter } from 'next/router'
import Intro from '../../../../components/Editar Perfil/Intro'
import Body from '../../../../components/Editar Perfil/Body'
//import Navbar from '../../../components/Layout/Navbar'
import Navbar from '../../../../components/Layout/NavbarLogged'
import Sidebar from '../../../../components/Layout/Sidebar'
import Footer from '../../../../components/Layout/Footer'
import styles from '../../../../styles/style'
import { menu, close } from '../../../../assets/index'
import { getDoc, doc, getFirestore, getDocs, query, where, collection } from "firebase/firestore"
import { getAuth } from "firebase/auth";
import { app } from '../../../../config'
import { Circles } from 'react-loader-spinner'
import Loader from '../../../../components/Layout/Loader'
import useState from 'react-usestateref'


export default function Editar() {

  const router = useRouter();

  const [toggle, setToggle] = useState(false)

  const [active, setActive] = useState(false)

  const [usuario, setUsuario, usuarioRef] = useState({})
  const [anuncios, setAnuncios] = useState({})

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

  const db = getFirestore(app);
  useEffect(() => {
    const getAnuncio = async () => {
      const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
      try {
        const userID = router.query.id
        const xRef = query(collection(db, 'users'), where('publicID',  '==', userID))
        const xQuerySnapshot = await getDocs(xRef)
        const xData = xQuerySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
        setAnuncios(xData)
        console.log("User data:", xData);
        //const docRef = doc(db, "users", "SpAUgjZCqggw63BZDQiZFGG21lm1");
        //const docSnap = await getDoc(docRef);
        //console.log("Document data:", docSnap.data());
        setUsuario(xData[0])
        console.log(usuarioRef.current)
        if (usuarioRef.current !== '') {
          const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), where('createdBy', '==', usuarioRef.current?.uid))
          const querySnapshot = await getDocs(itemsRef)
          const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
          setAnuncios(data)
          console.log("Anuncios data:", data);
          setLoading(false)
        } else {
          console.log('it is undefined')
        }
      } catch (e) {
        console.log(e)
      }
      if(usuarioRef.current?.uid !== userInfo.uid) {
        router.push('/market/mi-perfil')
      }
    }
    getAnuncio()
  }, [router.isReady])

  const auth = getAuth();

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
        <title>LibreCripto | Editar Mi Perfil</title>
        <meta name="description" content="Edita tu perfil de usuario en LibreCripto para personalizar tu información y preferencias." />
        <meta name="keywords" content="perfil de usuario, LibreCripto, preferencias, informacion, criptomonedas" />
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
            <Navbar title="Editar Mi Perfil" />
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
              <Body
                image={usuarioRef.current?.image}
                userName={usuarioRef.current?.name}
                userEmail = {usuarioRef.current?.email}
                userPhone = {usuarioRef.current?.phone}
                createdAt={usuarioRef.current?.createdAt}
                totalOperations={usuarioRef.current?.totalOperations}
                lastOperationDate={usuarioRef.current?.lastOperationDate}
                operationsPunctuation={usuarioRef.current?.operationsPunctuation}
                description={usuarioRef.current?.desc}
                load={loading}
                anuncios={anuncios}
                userID={usuarioRef.current?.uid}
                currentUser={auth?.currentUser}
                provider={usuarioRef.current?.authProvider}
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