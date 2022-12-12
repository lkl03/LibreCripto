import { useContext, useState, useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { FaTimes } from 'react-icons/fa'
import { HiStar } from 'react-icons/hi'
import { MdWarningAmber } from 'react-icons/md'
import Moment from 'react-moment';
import 'moment/locale/es';
import Map from './Map'
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc } from "firebase/firestore"
import { app } from '../../config'
import { now } from 'moment'

const Anuncio = ({ image, userName, createdAt, totalOperations, lastOperationDate, operationsPunctuation, lat, lng, compra, venta, amount, currency, P2P, F2F, fee, publisher }) => {
    let { user, logout } = useContext(AppContext)

    const db = getFirestore(app);

    const [showLogin, setShowLogin] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [tipoReporte, setTipoReporte] = useState('Anuncio')

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
                    motivo,
                    comentarios,
                    createdAt: now(),
                    userReporting: user.uid,
                    userReported: publisher,
                    tipoReporte
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
        <section id='anuncios' className={`w-full flex md:flex-col flex-col ${styles.paddingY} xs:mt-20`}>
            <div className={`flex md:flex-row flex-col mb-5`}>
                <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                    <div className='flex flex-wrap justify-start md:items-start items-center'>
                        <div className={`flex flex-wrap flex-col justify-start items-center mt-5`}>
                            <div className="rounded-full md:h-60 md:w-60 ss:h-40 ss:w-40 h-20 w-20 profile-icon">
                                <img className='rounded-full w-full h-auto' src={image ? image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg'} alt="" />
                            </div>
                        </div>
                        <div className={`flex flex-wrap flex-col justify-start items-start ss:ml-5 ss:mt-5`}>
                            <p className='text-[#ffffff80] italic'>{userName ? `@${userName.split(/\s+/).join('').toLowerCase()}` : ''}</p>
                            <p className='font-montserrat font-bold text-center ss:text-[52px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>{userName ? userName : ''}</p>
                            <p className='font-montserrat font-normal text-center ss:text-[24px] text-[20px] text-white ss:leading-[45px] leading-[20px]'>Anuncio publicado <Moment className='text-orange' fromNow locale="es">{createdAt}</Moment></p>
                            <Link href={`/market/perfil/${publisher}`}>
                                <a className={`${layout.link} font-montserrat mt-4`}>Ver perfil</a>
                            </Link>
                        </div>
                    </div>
                </div>
                <div className='flex flex-wrap md:w-[30%] w-[100%] border-2 rounded-xl sm:border-orange border-white md:mt-[4.5rem]'>
                    <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Datos del usuario</p>
                    </div>
                    <ul className='w-full py-[4rem]'>
                        {totalOperations !== '' ? <li className={`${styles.paragraph} text-white text-center`}><span className='text-orange'>{totalOperations}</span> operaciones concretadas</li> : <li className={`${styles.paragraph} text-white text-center`}>¡Aún no realizó operaciones!</li>}
                        {lastOperationDate !== '' ? <li className={`${styles.paragraph} text-white text-center`}>Última operación <Moment className='text-orange' fromNow locale="es">{lastOperationDate}</Moment></li> : <li className={`${styles.paragraph} text-white text-center`}>¡Aún no realizó operaciones!</li>}
                        {operationsPunctuation !== '' ? <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}><span className='flex flex-wrap items-center justify-center text-orange'>{operationsPunctuation} <HiStar /></span> calificación promedio</li> :  <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}>¡Aún no recibió calificaciones!</li>}
                    </ul>
                </div>
            </div>
            <div className={`flex md:flex-row flex-col flex-wrap justify-between items-center`}>
                <div className='md:w-[60%] w-full md:mb-auto mb-8'>
                    <p className={`${styles.paragraph} text-start text-white sm:text-xl`}>Ubicación</p>
                    {lat && lng && <Map lat={lat} lng={lng} />}
                </div>
                <div className='md:w-[auto] md:max-w-[30%] w-full flex flex-wrap items-center justify-center gap-10'>
                    <div>
                        <p className={`${styles.paragraph} text-center text-white sm:text-2xl font-medium`}>{`${!compra ? '' : 'Compra'} ${!venta ? '' : 'Vende'}`}</p>
                        <p className={`${styles.paragraph} text-center text-orange sm:text-3xl font-medium`}>{`${amount} ${currency}`}</p>
                    </div>
                    <div>
                        <p className={`${styles.paragraph} text-center text-white sm:text-2xl font-medium`}>Acepta</p>
                        <p className={`${styles.paragraph} text-center text-orange sm:text-3xl font-medium`}>{`${!P2P ? '' : 'P2P'} ${!F2F ? '' : 'F2F'}`}</p>
                    </div>
                    <div>
                        <p className={`${styles.paragraph} text-center text-white sm:text-2xl font-medium`}>Fee</p>
                        <p className={`${styles.paragraph} text-center text-orange sm:text-3xl font-medium`}>{fee}%</p>
                    </div>
                    <Link href="/">
                        <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>Contactar</a>
                    </Link>
                    <p onClick={() => setShowLogin(true)} className={` text-red-500 hover:text-white font-medium transition-all duration-300 ease-in-out flex flex-wrap items-center justify-center gap-1 cursor-pointer`}><MdWarningAmber />Reportar anuncio</p>
                    {/*LoginPopup*/}
                    {showLogin ? <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                        <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                            <FaTimes onClick={() => closePopUp()} />
                        </div>

                        <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                            <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¿Por qué queres reportar este anuncio?</p>
                            <div className='w-full mt-5 mb-5'>
                                <form onSubmit={handleSubmit} className='flex flex-col flex-wrap w-full items-center justify-center mt-5 mb-5 gap-5'>
                                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                                        <label className='text-white font-medium text-start'>Motivo</label>
                                        <select className='${styles.paragraph} font-medium font-montserrat text-white sm:text-[17px] text-sm input p-3 outline-none' value={motivo} onChange={(e) => setMotivo(e.target.value)}>
                                            {options.map(option => (
                                                <option className='text-black' key={option.value} value={option.value}>
                                                    {option.text}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                    <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                                        <label htmlFor="regemail" className='text-white font-medium text-start'>Agregar comentarios</label>
                                        <textarea onChange= {(e) => setComentarios(e.target.value)} className='input p-3 text-white outline-none'/>
                                    </div>
                                    <input type='hidden' value={tipoReporte} />
                                    <button type='submit' className={`${layout.buttonWhite} w-[90%] mt-5`}>
                                        Reportar
                                    </button>
                                    <div className='text-red-600'>{error}</div>
                                    <div className='text-green-600'>{success}</div>
                                </form>
                            </div>
                        </div>
                    </div> : ''}
                </div>
            </div>
        </section>
    )
}

export default Anuncio