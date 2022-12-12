import { useContext, useEffect, useState, useRef, useCallback, useMemo } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { HiSearch } from 'react-icons/hi'
import { FaCheck, FaTimes} from 'react-icons/fa'
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc } from "firebase/firestore"
import { app } from '../../config'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import axios from "axios";
import Cripto from './Cripto'
import { Circles } from 'react-loader-spinner'
import Moment from 'react-moment';
import 'moment/locale/es';
import {
    GoogleMap,
    Marker,
    useJsApiLoader,
    Autocomplete,
} from '@react-google-maps/api'
import usePlacesAutocomplete, {
    getGeocode,
    getLatLng,
} from "use-places-autocomplete";
import {
    Combobox,
    ComboboxInput,
    ComboboxPopover,
    ComboboxList,
    ComboboxOption,
} from "@reach/combobox";
import "@reach/combobox/styles.css";
import { now } from 'moment'

const PlacesAutocomplete = ({ setUbicacion }) => {
    const {
        ready,
        value,
        setValue,
        suggestions: { status, data },
        clearSuggestions,
    } = usePlacesAutocomplete();
    const handleSelect = async (address) => {
        setValue(address, false);
        clearSuggestions();
        const results = await getGeocode({ address });
        const { lat, lng } = getLatLng(results[0]);
        setUbicacion({ lat, lng });
        console.log(lat);
        console.log(lng);
    };
    return (
        <Combobox onSelect={handleSelect}>
            <ComboboxInput
                value={value}
                onChange={(e) => setValue(e.target.value)}
                disabled={!ready}
                className="input p-3 text-white outline-none w-full"
                placeholder='Buenos Aires, Argentina'
            />
            <ComboboxPopover>
                <ComboboxList>
                    {status === "OK" &&
                    data.map(({ place_id, description }) => (
                    <ComboboxOption key={place_id} value={description} />
                    ))}
                </ComboboxList>
            </ComboboxPopover>
        </Combobox>
    )
}

const Body = () => {
    let { user, logout } = useContext(AppContext)

    const db = getFirestore(app);

    const [showLogin, setShowLogin] = useState(false);
    const [error, setError] = useState("");

    const center = useMemo(() => ({ lat: -34.6000000, lng: -58.4500000 }), []);
    const [ubicacion, setUbicacion] = useState(null);
    const containerStyle = {
        width: '100%',
        height: '400px',
        borderRadius: 12,
    };

    const { isLoaded } = useJsApiLoader({
        id: 'google-map-script',
        googleMapsApiKey: 'AIzaSyC4ilNsb_eRVrPHjAsM_Qnt7cZvo7Qf1H0',
        libraries: ['places'],
    })

    const addressRef = useRef()

    const onLoad = useCallback(function callback(map) {
        const bounds = new window.google.maps.LatLngBounds(center);
        map.fitBounds(bounds);
        setMap(map)
    }, [])

    const onUnmount = useCallback(function callback(map) {
        setMap(null)
    }, [])

    const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

    const [directionsResponse, setDirectionsResponse] = useState(null)
    const originRef = useRef()


    const options = [
        { value: 'Dólar estadounidense', text: 'Dólar estadounidense (USD)' },
        { value: 'Bitcoin', text: 'Bitcoin (BTC)' },
        { value: 'Ethereum', text: 'Ethereum (ETH)' },
        { value: 'Binance Coin', text: 'Binance Coin (BNB)' },
        { value: 'Cardano', text: 'Cardano (ADA)' },
        { value: 'Dogecoin', text: 'Dogecoin (DOGE)' },
        { value: 'Ripple', text: 'Ripple (XRP)' },
        { value: 'Polkadot', text: 'Polkadot (DOT)' },
        { value: 'Uniswap', text: 'Uniswap (UNI)' },
        { value: 'Litecoin', text: 'Litecoin (LTC)' },
        { value: 'Chainlink', text: 'Chainlink (LINK)' },
        { value: 'Tether', text: 'Tether (USDT)' },
        { value: 'USD Coin', text: 'USD Coin (USDC)' },
        { value: 'Binance USD', text: 'Binance USD (BUSD)' },
        { value: 'DAI', text: 'DAI (DAI)' },

    ];

    const [moneda, setMoneda] = useState(options[0].value);
    const [cantidad, setCantidad] = useState("");
    const [fee, setFee] = useState("");
    const [f2f, setF2F] = useState(false);
    const [p2p, setP2P] = useState(false);
    const [compra, setCompra] = useState(false);
    const [venta, setVenta] = useState(false);
    const [operacion, setOperacion] = useState('yes');


    const handleSubmit = (event) => {
        event.preventDefault();
        console.log([
            moneda,
            cantidad,
            fee,
            f2f,
            p2p,
            ubicacion,
            operacion
        ])
        if (moneda && cantidad && fee && (f2f || p2p) && ubicacion && operacion) {
            try {
                addDoc(collection(db, "anuncios"), {
                    currency: moneda,
                    amount: parseInt(cantidad),
                    fee: parseFloat(fee),
                    F2F: f2f,
                    P2P: p2p,
                    location: {
                        0: ubicacion.lat,
                        1: ubicacion.lng
                    },
                    compra: operacion === 'compra' ? true : false,
                    venta: operacion === 'venta' ? true : false,
                    createdAt: now(),
                    createdBy: user.uid,
                    active: true
                }).then(
                    setShowLogin(true)
                )
            }
            catch (e) {
                console.log("Error getting cached document:", e);
            }
        } else {
            setError("Algun campo está vacio, por favor llená todos los campos para publicar tu anuncio.")
        }
    }


    return isLoaded ? (
        <section id='body' className={`flex flex-wrap flex-col ${styles.paddingY} xs:mt-20`}>
                {showLogin ? <div className={`absolute flex flex-col h-screen justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white mt-5`}>¡Anuncio publicado exitosamente!</p>
                        <div className='w-full mt-5 mb-5'>
                            <div className='flex flex-col flex-wrap w-full items-center justify-center mb-5 gap-5'>
                                <Link href='/market'>
                                <a className={`${layout.buttonWhite} w-[90%]`}>
                                    Volver al Mercado Cripto
                                </a>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div> : ''}
            <div className='w-full mb-4'>
                <h3 className={`${styles.heading4} md:text-start text-center`}>Gratis, de inmediato y con la más alta exposición.</h3>
                <p className={`${styles.paragraph} text-white sm:text-[18px] text-sm md:text-start text-center`}>Tip: si necesitás ayuda podes ver nuestro video <span className='text-orange'>Guía para la creación de anuncios</span></p>
            </div>
            <div className={showLogin ? `flex flex-col md:w-[100%] w-full h-screen` : `flex flex-col md:w-[100%] w-full`}>
            {showLogin ? '' : <><form className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5' onSubmit={handleSubmit}>
                    <div className='text-red-600'>{error}</div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="regemail" className='text-white font-medium text-start'>Moneda</label>
                        <select className='${styles.paragraph} font-medium font-montserrat text-white sm:text-[17px] text-sm input p-3 outline-none' value={moneda} onChange={(e) => setMoneda(e.target.value)}>
                            {options.map(option => (
                                <option className='text-black' key={option.value} value={option.value}>
                                    {option.text}
                                </option>
                            ))}
                        </select>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="cantidad" className='text-white font-medium text-start'>Cantidad</label>
                        <input type="number" min="0" id='cantidad' name='cantidad' autoComplete="cantidad" placeholder='0' step='0.1' className='input p-3 text-white outline-none' value={cantidad} onChange={(e) => setCantidad(e.target.value)}></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="fee" className='text-white font-medium text-start'>% Fee</label>
                        <input type="number" min="0" max="100" id='fee' name='fee' autoComplete="fee" placeholder='0.1' step='0.1' className='input p-3 text-white outline-none' value={fee} onChange={(e) => setFee(e.target.value)}></input>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="" className='text-white font-medium'>Operación</label>
                        <div className='flex flex-row-reverse justify-end items-center flex-wrap gap-2 op-select'>
                            <input type="radio" name="operacion" id="compra" value="compra" checked={operacion === 'compra'} onChange={(e) => setOperacion(e.target.value)} />
                            <label htmlFor="compra" className='text-white font-medium'>Compra</label>
                            <input type="radio" name="operacion" id="venta" value="venta" checked={operacion === 'venta'} onChange={(e) => setOperacion(e.target.value)} />
                            <label htmlFor="venta" className='text-white font-medium'>Venta</label>
                        </div>
                    </div>
                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                        <label htmlFor="" className='text-white font-medium'>Método</label>
                        <div className='flex flex-row-reverse justify-end items-center flex-wrap gap-2 met-select'>
                            <input type="checkbox" name="p2p" id="p2p" checked={p2p} onChange={(e) => setP2P(!p2p)} />
                            <label htmlFor="p2p" className='text-white font-medium'>P2P</label>
                            <input type="checkbox" name="f2f" id="f2f" checked={f2f} onChange={(e) => setF2F(!f2f)} />
                            <label htmlFor="f2f" className='text-white font-medium'>F2F</label>
                        </div>
                    </div>
                    <div className='flex flex-row-reverse justify-end items-center flex-wrap w-[90%] gap-2'>
                        <label htmlFor="" className='text-white font-medium'>Ubicación</label>
                        <>
                            <div className="places-container w-full">
                                <PlacesAutocomplete setUbicacion={setUbicacion} />
                            </div>
                            <GoogleMap
                                mapContainerStyle={containerStyle}
                                center={center}
                                zoom={9}
                                options={{
                                    streetViewControl: true,
                                    mapTypeControl: true,
                                    zoomControl: true,
                                    fullscreenControl: true,
                                }}
                            >
                                {ubicacion && <Marker position={ubicacion} />}
                            </GoogleMap>
                        </>
                    </div>
                    <button type='submit' className={`${layout.buttonWhite} sm:w-[25%] w-[90%] mt-5`}>
                        <a>Publicar anuncio</a>
                    </button>
                </form></>}
            </div>
        </section>
    ) : ''
}

export default Body