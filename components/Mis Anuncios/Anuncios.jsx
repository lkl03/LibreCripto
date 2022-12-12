import { useContext, useState, useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { HiSearch, HiOutlineRefresh } from 'react-icons/hi'
import { FaMapMarkerAlt, FaBitcoin, FaChevronDown } from 'react-icons/fa'

import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore } from "firebase/firestore"
import { app } from '../../config'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import axios from "axios";
import { Circles } from 'react-loader-spinner'
import Moment from 'react-moment';
import 'moment/locale/es';

const Anuncios = () => {
    let { user, logout } = useContext(AppContext)

    const [anuncios, setAnuncios] = useState([])
    const [anunciosAll, setAnunciosAll] = useState([])
    const [creators, setCreators] = useState({})
    const [loading, setLoading] = useState(true)

    const db = getFirestore(app);

    useEffect(() => {

        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()

        const getAnuncios = async () => {
            const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), where('createdBy', '==', userInfo.uid))
            const querySnapshot = await getDocs(itemsRef)
            const creatorUids = [...new Set(querySnapshot.docs.map(doc => doc.data().createdBy))]
            const creatorDocs = await Promise.all(creatorUids.map(uid => getDoc(doc(db, 'users', uid))))
            const creators = creatorDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
            setAnuncios(data)
            setCreators(creators)
            setLoading(false)
            console.log(anuncios)
            anuncios.map(anuncio =>
                console.log(anuncio.createdAt))
        }

        getAnuncios()

        const anunciosTotal = async () => {
            const itemsRef = query(collection(db, 'anuncios'), where('createdBy', '==', userInfo.uid))
            const querySnapshot = await getDocs(itemsRef)
            const creatorUids = [...new Set(querySnapshot.docs.map(doc => doc.data().createdBy))]
            const creatorDocs = await Promise.all(creatorUids.map(uid => getDoc(doc(db, 'users', uid))))
            const creators = creatorDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
            setAnunciosAll(data)
            setCreators(creators)
            setLoading(false)
            console.log(anunciosAll)
            anuncios.map(anuncio =>
                console.log(anuncio.createdAt))
        }

        anunciosTotal()
    }, [])

    const refreshAnuncios = async () => {
        setLoading(true)
        const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), where('createdBy', '==', userInfo.uid))
        const querySnapshot = await getDocs(itemsRef)
        const creatorUids = [...new Set(querySnapshot.docs.map(doc => doc.data().createdBy))]
        const creatorDocs = await Promise.all(creatorUids.map(uid => getDoc(doc(db, 'users', uid))))
        const creators = creatorDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
        const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
        setAnuncios(data)
        setCreators(creators)
        setLoading(false)
        console.log(anuncios)
        anuncios.map(anuncio =>
            console.log(anuncio.createdAt))
    }

    const { coords, isGeolocationAvailable, isGeolocationEnabled } =
        useGeolocated({
            positionOptions: {
                enableHighAccuracy: false,
            },
            userDecisionTimeout: 5000,
        });

    return (
        <section id='anuncios' className={`flex md:flex-row flex-col md:items-center ${styles.paddingY} xs:mt-20`}>
            <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                <div className='flex flex-col flex-wrap justify-between'>
                    <div className={`flex flex-col items-start justify-start mt-5`}>
                        <div className='flex flex-wrap md:w-[97%] w-[100%] md:h-[410px] h-auto border-2 rounded-tr-lg rounded-tl-lg sm:border-orange border-white max-h-[410px] overflow-y-scroll overflow-x-hidden'>
                            {loading
                                ?
                                <div className='mx-auto mt-4'><Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /></div>
                                :
                                anuncios.map(anuncio => (
                                    <Link href={`../market/anuncio/${anuncio.id}`} key={anuncio.id}>
                                        <a target="_blank" className='sm:w-[50%] w-[100%]'>
                                            <div className='border-2 rounded-xl border-orange card-anuncio cursor-pointer m-4'>
                                                <div className='flex flex-wrap p-6 items-start justify-between gap-2'>
                                                    <div className='flex flex-wrap items-center gap-2'>
                                                        <div className="rounded-full h-11 w-11 profile-icon">
                                                            <img className='rounded-full' src={user && user.photoURL !== null ? user.photoURL : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
                                                        </div>
                                                        <div className='flex-col flex-wrap justify-start items-start'>
                                                            <p className={`${styles.paragraph} text-center text-white font-medium`}>{creators[anuncio.createdBy]?.name}</p>
                                                            <p className={`font-montserrat font-normal text-sm text-center text-orange italic`}><Moment fromNow locale="es">{anuncio.createdAt}</Moment></p>
                                                        </div>
                                                    </div>
                                                    {!isGeolocationAvailable ? (
                                                        <div>Tu navegador no soporta geolocalización</div>
                                                    ) : !isGeolocationEnabled ? (
                                                        <div className='flex flex-wrap items-center justify-between gap-1'>
                                                            <p className={`${styles.paragraph} text-center text-white text-xs`}>Ubicación desactivada</p>
                                                            <FaMapMarkerAlt className='text-3xl text-orange' />
                                                        </div>
                                                    ) : coords ? (
                                                        <div className='flex flex-wrap items-center justify-between gap-1'>
                                                            <p className={`${styles.paragraph} text-center text-white font-medium`}>{
                                                                Math.round(convertDistance(getPreciseDistance(
                                                                    { latitude: anuncio.location?.[0], longitude: anuncio.location?.[1] },
                                                                    { latitude: -34.556532, longitude: -58.5382836 }
                                                                ), 'km'))
                                                            }km</p>
                                                            <FaMapMarkerAlt className='text-3xl text-orange' />
                                                        </div>) : (
                                                        <div>Obteniendo ubicación...&hellip; </div>
                                                    )
                                                    }
                                                </div>
                                                <div className='flex flex-wrap px-6 justify-around items-center gap-2'>
                                                    <div className='flex-col flex-wrap justify-start items-start'>
                                                        <p className={`${styles.paragraph} text-center text-white font-medium`}>{`${!anuncio.compra ? '' : 'Compras'} ${!anuncio.venta ? '' : 'Vendes'}`}</p>
                                                        <p className={`${styles.paragraph} text-start text-orange font-bold`}>{`${anuncio?.amount} ${anuncio?.currency}`}</p>
                                                    </div>
                                                    <div className='flex-col flex-wrap justify-start items-start'>
                                                        <p className={`${styles.paragraph} text-center text-white font-medium`}>Aceptas</p>
                                                        <p className={`${styles.paragraph} text-start text-orange font-bold`}>{`${!anuncio.P2P ? '' : 'P2P'} ${!anuncio.F2F ? '' : 'F2F'}`}</p>
                                                    </div>
                                                    <div className='flex-col flex-wrap justify-start items-start'>
                                                        <p className={`${styles.paragraph} text-center text-white font-medium`}>Fee</p>
                                                        <p className={`${styles.paragraph} text-start text-orange font-bold`}>{anuncio.fee}%</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </a>
                                    </Link>
                                ))}
                        </div>
                        {loading ? '' : <div className='flex items-center justify-center sm:bg-orange bg-white rounded-br-lg rounded-bl-lg card-info--title md:w-[97%] w-[100%]'>
                            <HiOutlineRefresh className='md:text-white text-orange hover:text-black text-3xl m-4 cursor-pointer transition-all duration-300 ease-in-out' onClick={() => refreshAnuncios()} />
                        </div>}
                    </div>
                    <div className='flex flex-wrap md:w-[97%] w-[100%] items-center justify-around'>
                        <div className='md:w-[49%] w-full flex items-center md:mt-[2rem]'>
                            <Link href="/market">
                                <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>
                                    Volver al Mercado Cripto
                                </a>
                            </Link>
                        </div>
                        <div className='md:w-[49%] w-full flex items-center md:mt-[2rem]'>
                            <Link href="/market/publicar">
                                <a className={`px-8 py-[1rem] bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-full text-center`}>
                                    Publicar un anuncio
                                </a>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
            <div>

            </div>
            <div className='flex flex-col md:w-[30%] w-[100%] items-center justify-center'>
                <div className='flex flex-wrap items-center justify-center border-2 rounded-xl sm:border-orange border-white max-h-[410px]'>
                    <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Estadísticas</p>
                    </div>
                    <div className='overflow-y-scroll overflow-x-hidden md:max-h-[85%]'>
                        <ul className='${styles.paragraph} text-center sm:text-white text-orange sm:text-xl mt-4 mb-4'>
                            <li><span className='font-medium text-orange'>{anunciosAll.length}</span> Anuncios publicados</li>
                            <li><span className='font-medium text-orange'>{anuncios.length}</span> Anuncios activos</li>
                            <li><span className='font-medium text-orange'>6</span> Operaciones concretadas</li>
                            <li><span className='font-medium text-orange'>6</span> Operaciones activas</li>
                            <li><span className='font-medium text-orange'>6</span> Conversaciones activas</li>
                        </ul>
                    </div>
                </div>
                <div className='md:w-[auto] w-full md:block flex items-center md:mt-[2rem]'>
                    <Link href="/market/mi-perfil">
                        <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>
                            Ver mi perfil
                        </a>
                    </Link>
                </div>
            </div>
        </section>
    )
}

export default Anuncios