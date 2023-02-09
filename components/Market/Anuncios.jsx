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
import Cripto from './Cripto'
import { Circles } from 'react-loader-spinner'
import Moment from 'react-moment';
import 'moment/locale/es';
import Ticker, { FinancialTicker, NewsTicker } from 'nice-react-ticker';

const Anuncios = ({ articles }) => {
    let { user, logout } = useContext(AppContext)

    console.log(user)

    const [anuncios, setAnuncios] = useState([])
    const [creators, setCreators] = useState({})
    const [loading, setLoading] = useState(true)
    const [cripto, setCripto] = useState([])
    const [search, setSearch] = useState('')

    const db = getFirestore(app);

    useEffect(() => {

        const getAnuncios = async () => {
            const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true))
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
    }, [])

    const getAnuncios = async () => {
        const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true))
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

    const refreshAnuncios = async () => {
        setLoading(true)
        const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true))
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

    /* START - Get Cripto Prices Data */
    useEffect(() => {
        axios.get("https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=10&page=1&sparkline=false")
        .then((res) => {
            setCripto(res.data);
        })
        .catch((error) => console.log(error));
      }, [2000]);

    const filteredCripto = cripto.filter((cripto) =>
        cripto.name.toLowerCase()
    );
    /* END - Get Cripto Prices Data */

    useEffect(() => {
        const delayDebounceFn = setTimeout(() => {
            if (search){
                setAnuncios(anuncios.filter(anuncio => 
                    anuncio?.currency?.toLowerCase().includes(search.toLowerCase()) ||
                    creators[anuncio.createdBy]?.name.toLowerCase().includes(search.toLowerCase())
                ))
                setSearch('')
            } else {
                const setDefaultAnuncios = async () => {
                    const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), orderBy('createdAt', 'desc'))
                    const querySnapshot = await getDocs(itemsRef)
                    const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
                    setAnuncios(data)
                }
                setDefaultAnuncios()
            }
        }, 3000)
    
        return () => clearTimeout(delayDebounceFn)
    }, [search])
    
    const options = [
        { value: 'desc', text: 'Más recientes' },
        { value: 'asc', text: 'Más antiguos' },
    ];

    const [selected, setSelected] = useState(options[0].value);

    useEffect (() => {
        console.log(selected)
        const sortElements = async () => {
            const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), orderBy('createdAt', selected))
            const querySnapshot = await getDocs(itemsRef)
            const creatorUids = [...new Set(querySnapshot.docs.map(doc => doc.data().createdBy))]
            const creatorDocs = await Promise.all(creatorUids.map(uid => getDoc(doc(db, 'users', uid))))
            const creators = creatorDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            const data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }))
            setAnuncios(data)
            setCreators(creators)
            setLoading(false)
        }
        sortElements()
    }, [selected])

    return (
        <>
        {/*<div className="newsticker mt-24 -mb-40 lg:block hidden">
          <Ticker isNewsTicker={true} className="w-full">
          {articles?.articles?.map((article, index) => (
                <NewsTicker key={index} id={index} icon={article.UrlToImage} title={article.title} url={article.url} meta={<Moment fromNow locale="es">{article.publishedAt}</Moment>}  />
           ))}
          </Ticker>
        </div>*/}
        <section id='anuncios' className={`flex md:flex-row flex-col md:items-center ${styles.paddingY} xs:mt-20`}>

            <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                <div className={`w-[100%] flex md:flex-row flex-col-reverse flex-wrap items-center justify-start gap-4 mt-5`}>
                    <div className='flex flex-wrap md:w-[70%] w-[100%] justify-evenly border-2 rounded-xl sm:border-orange border-white'>
                        <div className='flex flex-wrap m-4'>
                            <div className='flex flex-wrap items-center justify-between gap-2 border-b px:4'>
                                <HiSearch className='text-xl text-white' />
                                <input className={`${styles.paragraph} text-center text-white sm:text-[17px] text-sm bg-transparent outline-none`} placeholder="Buscar anuncios" value={search} onChange={(e) => {setSearch(e.target.value)}} />
                            </div>
                        </div>
                        <div className='flex flex-wrap m-4'>
                            <div className='flex flex-wrap items-center justify-between gap-2 border-b px:4'>
                                {/*<FaChevronDown className='text-xl text-white' />*/}
                                <p className={`${styles.paragraph} text-center text-white sm:text-[17px] text-sm`}>Ordenar por</p>
                                <select value={selected} onChange={(e) => setSelected(e.target.value)} className='${styles.paragraph} font-medium font-montserrat text-white sm:text-[17px] text-sm bg-transparent outline-none'>
                                    {options.map(option => (
                                        <option className='text-black' key={option.text} value={option.value}>
                                            {option.text}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div className='md:w-[auto] w-full md:block flex items-center'>
                        <Link href="/market/publicar">
                            <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>
                                Publicar un anuncio
                            </a>
                        </Link>
                    </div>
                </div>
                <div className='flex flex-col flex-wrap justify-between'>
                    <div className={`flex flex-col items-start justify-start mt-5`}>
                        <div className='flex flex-wrap md:w-[97%] w-[100%] md:h-[410px] h-auto border-2 rounded-tr-lg rounded-tl-lg sm:border-orange border-white max-h-[410px] overflow-y-scroll overflow-x-hidden'>
                            {loading 
                            ? 
                            <div className='mx-auto mt-4'><Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /></div>
                            : 
                            anuncios.map(anuncio => (
                                <Link href={`market/anuncio/${anuncio.id}`} key={anuncio.id}>
                                    <a target="_blank" className='sm:w-[50%] w-[100%]'>
                                        <div className='border-2 rounded-xl border-orange card-anuncio cursor-pointer m-4'>
                                            <div className='flex flex-wrap p-6 items-start justify-between gap-2'>
                                                <div className='flex flex-wrap items-center gap-2'>
                                                    <div className="rounded-full h-11 w-11 profile-icon">
                                                        <img className='rounded-full' src={creators[anuncio.createdBy]?.image} alt="" />
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
                                                    <div className={`${styles.paragraph} text-white`}>Obteniendo ubicación...&hellip; </div>
                                                )
                                                }
                                            </div>
                                            <div className='flex flex-wrap px-6 justify-around items-center gap-2'>
                                                <div className='flex-col flex-wrap justify-start items-start'>
                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>{`${!anuncio.compra ? '' : 'Compra'} ${!anuncio.venta ? '' : 'Vende'}`}</p>
                                                    <p className={`${styles.paragraph} text-start text-orange font-bold`}>{`${anuncio?.amount} ${anuncio?.currency}`}</p>
                                                </div>
                                                <div className='flex-col flex-wrap justify-start items-start'>
                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>Acepta</p>
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
                </div>
            </div>
            <div>

            </div>
            <div className='flex flex-wrap md:w-[30%] w-[100%] items-center justify-center border-2 rounded-xl sm:border-orange border-white md:mt-[4.5rem] md:h-[410px]'>
                <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                    <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Principales criptomonedas</p>
                </div>
                <div className='overflow-y-scroll overflow-x-hidden md:max-h-[85%]'>
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

            </div>

        </section>
        </>
    )
}

export default Anuncios