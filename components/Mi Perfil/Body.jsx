import { useContext, useState, useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { FaTimes } from 'react-icons/fa'
import { FaMapMarkerAlt } from 'react-icons/fa'
import { HiStar } from 'react-icons/hi'
import { MdWarningAmber } from 'react-icons/md'
import Moment from 'react-moment';
import 'moment/locale/es';
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc, updateDoc } from "firebase/firestore"
import { app } from '../../config'
import { now } from 'moment'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import { Circles } from 'react-loader-spinner'

const Body = () => {
    let { user, logout } = useContext(AppContext)

    const db = getFirestore(app);

    const [showLogin, setShowLogin] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [loading, setLoading] = useState(true)
    const [infoUser, setInfoUser] = useState('')
    const [anuncios, setAnuncios] = useState([])
    const [creators, setCreators] = useState({})

    useEffect(() => {
        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
        const getUser = async () => {
          try {
            const query = userInfo?.uid
            const docRef = doc(db, "users", query);
            const docSnap = await getDoc(docRef);
            console.log("Document data:", docSnap.data());
            setInfoUser(docSnap.data())
            setLoading(false)
          } catch (e) {
            console.log(e)
          }
        }
        getUser()

        const getAnuncios = async () => {
            const itemsRef = query(collection(db, 'anuncios'), where('active', '==', true), where('createdBy', '==', userInfo?.uid || user?.uid))
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

    const { coords, isGeolocationAvailable, isGeolocationEnabled } =
    useGeolocated({
        positionOptions: {
            enableHighAccuracy: false,
        },
        userDecisionTimeout: 5000,
    });


    const options = [
        { value: 'Datos falsos', text: 'Datos falsos' },
        { value: 'Anuncio repetido', text: 'Anuncio repetido' },
        { value: 'Usuario con malas prácticas', text: 'Usuario con malas prácticas' },
        { value: 'Otro', text: 'Otro' }
    ];

    const [motivo, setMotivo] = useState(options[0].value);
    const [comentarios, setComentarios] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log([
            motivo,
            comentarios,
            userName
        ])
        if (motivo && comentarios) {
            try {
                addDoc(collection(db, "reportes"), {
                    motivo: motivo,
                    comentarios: comentarios,
                    createdAt: now(),
                    userReporting: user.uid,
                    userReported: userName,
                }).then(
                    setSuccess("Anuncio reportado exitosamente. Pronto estaremos en contacto con vos acerca del estado de tu reporte."),
                    setError("")
                )
            }
            catch (e) {
                console.log("Error getting cached document:", e);
            }
        } else {
            setError("Algun campo está vacio, por favor llená todos los campos para hacer tu reporte.")
        }
    }

    const closePopUp = () => {
        setShowLogin(false)
        setError("")
        setSuccess("")
    }

    return (
        <section id='perfil' className={`w-full flex md:flex-col flex-col sm:pb-12 pb-6 xs:-mt-40`}>
            <div className={`flex md:flex-row flex-col flex-wrap justify-between mb-5`}>
                <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                    <div className='flex flex-wrap justify-start md:items-start items-center'>
                        <div className={`flex flex-wrap flex-col justify-start items-center mt-5`}>
                            <div className="rounded-full md:h-60 md:w-60 ss:h-40 ss:w-40 h-20 w-20 profile-icon">
                                <img referrerPolicy="no-referrer" className='rounded-full w-full h-auto' src={user && user.photoURL !== null ? infoUser.image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
                            </div>
                        </div>
                        <div className={`flex flex-wrap flex-col justify-start items-start ss:ml-5 ss:mt-[7.5rem]`}>
                            <p className='text-[#ffffff80] italic'>{user ? `@${user.displayName.split(/\s+/).join('').toLowerCase()}` : ''}</p>
                            <p className='font-montserrat font-bold text-center ss:text-[52px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>{user ? user?.displayName : ''}</p>
                            <p className='font-montserrat font-normal text-center ss:text-[24px] text-[20px] text-white ss:leading-[45px] leading-[20px]'>Miembro desde <Moment className='text-orange' fromNow locale="es">{infoUser?.createdAt}</Moment></p>
                        </div>
                    </div>
                </div>
                <div className='flex flex-wrap md:w-[30%] w-[100%] justify-start items-start md:mt-[12.5rem]'>
                    {infoUser?.desc !== '' ? <p className='font-montserrat text-end ss:text-[18px] text-[16px] text-white'>"<span className='italic'>{`${infoUser?.desc}`}</span>"</p> : <p className='font-montserrat text-end text-[14px] text-gray-400'>¡Parece que todavía no tenés una descripción! Podes añadir una desde la sección 'Editar perfil' ;)</p>}
                </div>
                <div className='flex flex-wrap md:w-[30%] w-[100%] border-2 rounded-xl sm:border-orange border-white md:mt-0 mt-4'>
                    <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Datos del usuario</p>
                    </div>
                    <ul className='w-full py-[4rem]'>
                        {infoUser?.totalOperations !== '' ? <li className={`${styles.paragraph} text-white text-center`}><span className='text-orange'>{user ? infoUser?.totalOperations : ''}</span> operaciones concretadas</li> : <li className={`${styles.paragraph} text-white text-center`}>¡Aún no realizaste operaciones!</li>}
                        {infoUser?.lastOperationDate !== '' ? <li className={`${styles.paragraph} text-white text-center`}>Última operación <Moment className='text-orange' fromNow locale="es">{infoUser?.lastOperationDate}</Moment></li> : <li className={`${styles.paragraph} text-white text-center`}>¡Aún no realizaste operaciones!</li>}
                        {infoUser?.operationsPunctuation !== '' ? <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}><span className='flex flex-wrap items-center justify-center text-orange'>{infoUser?.operationsPunctuation} <HiStar /></span> calificación promedio</li> : <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}>¡Aún no recibiste calificaciones!</li>}
                    </ul>
                </div>
                <div className='flex flex-wrap md:w-[65%] w-full border-2 rounded-xl sm:border-orange border-white md:mt-0 mt-4'>
                <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Anuncios activos</p>
                    </div>
                <div className='flex flex-col flex-wrap justify-between w-full'>
                        <div className='flex flex-wrap w-full md:h-[220px] h-auto rounded-tr-lg max-h-[410px] overflow-y-scroll overflow-x-hidden'>
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
                                                            <img referrerPolicy="no-referrer" className='rounded-full' src={user ? user.photoURL : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
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
                </div>
                </div>
            </div>
            <div className={`flex md:flex-row flex-col flex-wrap justify-between items-center`}>
                <div className='md:w-[auto] md:max-w-[30%] w-full flex flex-wrap items-center justify-center gap-10 m-auto'>
                    <Link href={`../market/mi-perfil/editar/${user?.uid}`}>
                        <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>Editar perfil</a>
                    </Link>
                </div>
            </div>
        </section>
    )
}

export default Body