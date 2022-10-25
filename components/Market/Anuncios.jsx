import { useContext, useState, useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { privacidad } from '../../constants'
import { AppContext } from '../AppContext'
import { HiSearch } from 'react-icons/hi'
import { FaMapMarkerAlt, FaBitcoin, FaChevronDown } from 'react-icons/fa'

import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore } from "firebase/firestore"
import { app } from '../../config'
import { useGeolocated } from "react-geolocated";
import getDistance from 'geolib/es/getDistance';
import axios from "axios";
import Cripto from './Cripto'

const Anuncios = () => {
    let { user, logout } = useContext(AppContext)

    const [anuncios, setAnuncios] = useState([])
    const [creators, setCreators] = useState({})
    const [loading, setLoading] = useState(true)
    const [cripto, setCripto] = useState([]);

    const db = getFirestore(app);


    //useEffect(() => {

        //const itemsRef = query(collection(db, 'anuncios'))
        //getDocs(itemsRef)
            //.then(res => {
                //setAnuncios(res.docs.map((item) => ({ anuncioID: item.id, ...item.data() })
                //))
                //setCreadorAnuncio(res.docs.map((item) => (item.data().createdBy)))
            //})
            //.finally(() => setLoading(false))

    //}, [])

    useEffect(() => {

        const getAnuncios = async () => {
            // Fetch Anuncios
            const itemsRef = query(collection(db, 'anuncios'))
            const querySnapshot = await getDocs(itemsRef)
            // Array of creator UIDs
            const creatorUids = [...new Set(querySnapshot.docs.map(doc => doc.data().createdBy))]
            //console.log(creatorUids)
            const creatorDocs = await Promise.all(creatorUids.map(uid => getDoc(doc(db, 'users', uid))))
            //console.log(creatorDocs)
            // Store creators data in a Map
            const creators = creatorDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            console.log(creators)
            //console.log(creators)
            // Update state after creators data is fetched
            setAnuncios(querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id })))
            setCreators(creators)
            console.log(creators)

            anuncios.map(anuncio => (
                console.warn(anuncio),
                console.error(creators[anuncio.createdBy]?.name)
            ))
        }

        getAnuncios()
    }, [])
    

    
    //(creadorAnuncio.map((creador, i) => {
    //console.log(creador)
    //let q = query(collection(db, "users"), where("uid", "==", creador));
    //getDocs(q).then(res => {
    //let x = res.docs.map((item) => (item.data().name))
    //console.log(x)
    //})
    //}))

    {/*ESTE ES EL CORRECTO, HAY QUE PASARLO ADENTRO DEL MAP DE CADA ANUNCIO, LINEA 70 ;) */ }
    //anuncios.map((anuncio, i) => {
    //console.log(creadorAnuncio)
    //let q = query(collection(db, "users"), where("uid", "==", creadorAnuncio[i]));
    //getDocs(q).then(res => {
    //let x = res.docs.map((item) => (item.data().name))
    //console.log(x)
    //})
    //})

    const { coords, isGeolocationAvailable, isGeolocationEnabled } =
        useGeolocated({
            positionOptions: {
                enableHighAccuracy: false,
            },
            userDecisionTimeout: 5000,
        });

    //console.log(coords)

    getDistance(
        { latitude: 51.5103, longitude: 7.49347 },
        { latitude: "51° 31' N", longitude: "7° 28' E" }
    );


    /* START - Get Cripto Prices Data */
    useEffect(() => {
        axios.get("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10&page=1&sparkline=false")
        .then((res) => {
            setCripto(res.data);
            //console.log(res.data);
        })
        .catch((error) => console.log(error));
      }, [2000]);

    const filteredCripto = cripto.filter((cripto) =>
        cripto.name.toLowerCase()
    );
    /* END - Get Cripto Prices Data */

    return (
        <section id='anuncios' className={`flex md:flex-row flex-col ${styles.paddingY} xs:mt-20`}>
            <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                <div className={`w-[100%] flex md:flex-row flex-col-reverse flex-wrap items-center justify-start gap-4 mt-5`}>
                    <div className='flex flex-wrap md:w-[70%] w-[100%] justify-evenly border-2 rounded-xl sm:border-orange border-white'>
                        <div className='flex flex-wrap m-4'>
                            <div className='flex flex-wrap items-center justify-between gap-2 border-b px:4'>
                                <HiSearch className='text-2xl text-white' />
                                <p className={`${styles.paragraph} text-center text-white sm:text-[18px] text-sm`}>Buscar anuncios</p>
                            </div>
                        </div>
                        <div className='flex flex-wrap m-4'>
                            <div className='flex flex-wrap items-center justify-between gap-2 border-b px:4'>
                                <FaChevronDown className='text-2xl text-white' />
                                <p className={`${styles.paragraph} text-center text-white sm:text-[18px] text-sm`}>Ordenar por <span className='font-medium'>Más Recientes</span></p>
                            </div>
                        </div>
                    </div>
                    <div className='md:w-[auto] w-full md:block flex items-center'>
                        <Link href="/">
                            <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>
                                Publicar un anuncio
                            </a>
                        </Link>
                    </div>
                </div>
                <div className='flex flex-col flex-wrap justify-between'>
                    <div className={`${layout.sectionInfo} mt-5`}>
                        <div className='flex flex-wrap md:w-[97%] w-[100%] border-2 rounded-xl sm:border-orange border-white'>
                            {anuncios.map(anuncio => (
                                <Link href='/' key={anuncio.id}>
                                    <a target="_blank" className='sm:w-[50%] w-[100%]'>
                                        <div className='border-2 rounded-xl border-orange card-anuncio cursor-pointer m-4'>
                                            <div className='flex flex-wrap p-6 items-start justify-between gap-2'>
                                                <div className='flex flex-wrap items-center gap-2'>
                                                    <div className="rounded-full h-11 w-11 profile-icon">
                                                        <img className='rounded-full' src={user ? user.photoURL : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
                                                    </div>
                                                    <div className='flex-col flex-wrap justify-start items-start'>
                                                        <p className={`${styles.paragraph} text-center text-white font-medium`}>{creators[anuncio.createdBy]?.name}</p>
                                                        <p className={`font-montserrat font-normal text-sm text-center text-orange italic`}>Hace 24 días</p>
                                                    </div>
                                                </div>
                                                {!isGeolocationAvailable ? (
                                                    <div>Your browser does not support Geolocation</div>
                                                ) : !isGeolocationEnabled ? (
                                                    <div className='flex flex-wrap items-center justify-between gap-1'>
                                                        <p className={`${styles.paragraph} text-center text-white text-xs`}>Ubicación desactivada</p>
                                                        <FaMapMarkerAlt className='text-3xl text-orange' />
                                                    </div>
                                                ) : coords ? (
                                                    <div className='flex flex-wrap items-center justify-between gap-1'>
                                                        <p className={`${styles.paragraph} text-center text-white font-medium`}>5KM</p>
                                                        <FaMapMarkerAlt className='text-3xl text-orange' />
                                                    </div>) : (
                                                    <div>Getting the location data&hellip; </div>
                                                )
                                                }
                                            </div>
                                            <div className='flex flex-wrap px-6 justify-around items-center gap-2'>
                                                <div className='flex-col flex-wrap justify-start items-start'>
                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>Vende</p>
                                                    <p className={`${styles.paragraph} text-start text-orange font-bold`}>{`${anuncio?.amount} ${anuncio?.currency}`}</p>
                                                </div>
                                                <div className='flex-col flex-wrap justify-start items-start'>
                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>Acepta</p>
                                                    <p className={`${styles.paragraph} text-start text-orange font-bold`}>P2P F2F</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </Link>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
            <div className='flex flex-wrap md:w-[30%] w-[100%] border-2 rounded-xl sm:border-orange border-white md:mt-[4.5rem]'>
                <div className='w-full bg-orange rounded-tr-lg rounded-tl-lg card-info--title'>
                    <p className={`${styles.paragraph} text-center text-white sm:text-xl font-medium mt-4 mb-4`}>Principales criptomonedas</p>
                </div>
                    {filteredCripto.map((cripto) => {
                        return (
                        <Cripto
                            key={cripto.id}
                            name={cripto.name}
                            price={cripto.current_price}
                            symbol={cripto.symbol}
                            marketcap={cripto.total_volume}
                            volume={cripto.market_cap}
                            image={cripto.image}
                            priceChange={cripto.price_change_percentage_24h}
                        />
                        );
                    })}

            </div>

        </section>
    )
}

export default Anuncios