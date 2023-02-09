import { useContext, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from "next/router"
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { FaTimes, FaWhatsapp } from 'react-icons/fa'
import { HiStar } from 'react-icons/hi'
import { MdWarningAmber } from 'react-icons/md'
import Moment from 'react-moment';
import 'moment/locale/es';
import Map from './Map'
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, addDoc, setDoc, updateDoc } from "firebase/firestore"
import { app } from '../../config'
import { now } from 'moment'
import axios from 'axios'
import useState from 'react-usestateref'
import { round } from 'lodash';

const Anuncio = ({ image, status, anuncioID, userName, userEmail, createdAt, createdBy, totalOperations, lastOperationDate, operationsPunctuation, lat, lng, compra, venta, amount, currency, P2P, F2F, fee, publisher, publisherPublicID, phone }) => {
    let { user, logout } = useContext(AppContext)

    const router = useRouter();

    const db = getFirestore(app);

    const [userPublicID, setUserPublicID, userPublicIDRef] = useState('')

    const [showLogin, setShowLogin] = useState(false);
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [tipoReporte, setTipoReporte] = useState('Anuncio')
    const [contactado, setContactado] = useState(false)
    const [datainEmail, setDatainEmail, datainEmailRef] = useState({
        email: '',
        name: '',
        userContacta: ''
    })

    const options = [
        { value: 'Datos falsos', text: 'Datos falsos' },
        { value: 'Anuncio repetido', text: 'Anuncio repetido' },
        { value: 'Usuario con malas prácticas', text: 'Usuario con malas prácticas' },
        { value: 'Otro', text: 'Otro' }
    ];

    useEffect(() => {

    }, [])
    

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

    const pressedButton = async () => {
        setContactado(true)
        const docRef = doc(db, "users", user?.uid);
        const docSnap = await getDoc(docRef);
        if (docSnap.exists()) {
            setUserPublicID(docSnap.data().publicID)
        } else {
            console.log("Error getting info");
        }
        try {
            const q = query(collection(db, "operaciones"), where("anuncio", "==", anuncioID));
            getDocs(q).then(res => {
            if (res.docs.length === 0) {
            addDoc(collection(db, "operaciones"), {
                createdAt: now(),
                userContacta: user.uid,
                userContactado: publisher,
                anuncio: anuncioID,
                status: 'En curso',
                active: true,
                finishedAt: ''
            })
            const anuncioRef = doc(db, "anuncios", anuncioID);
            updateDoc(anuncioRef, {
              active: false,
              status: 'hidden'
            });
            setDatainEmail({
                email: userEmail,
                name: userName,
                userContacta: user.displayName
            })
            fetch("../../api/newoperation", {
                "method": "POST",
                "headers": { "content-type": "application/json" },
                "body": JSON.stringify(datainEmailRef.current)
            })
            }})
        }
        catch (e) {
            console.log("Error getting cached document:", e);
        }
        const chatData = {
            usernames: [userPublicIDRef.current, publisherPublicID],
            title: "Nuevo chat",
            is_direct_chat: true
        };
        axios.put('https://api.chatengine.io/chats/', chatData, {
            headers: {
                "Private-key": "07707db6-68e3-40c0-b17c-b71a74c742d8"
            }
        }).then(response => {
            router.push("/market/mis-chats");
        }).catch(error => {
            console.error(error);
        });
    }
    const pressedButtonWhatsapp = () => {
        setContactado(true)
        try {
            const q = query(collection(db, "operaciones"), where("anuncio", "==", anuncioID));
            getDocs(q).then(res => {
            if (res.docs.length === 0) {
            addDoc(collection(db, "operaciones"), {
                createdAt: now(),
                userContacta: user.uid,
                userContactado: publisher,
                anuncio: anuncioID,
                status: 'En curso',
                active: true
            })
            const anuncioRef = doc(db, "anuncios", anuncioID);
            updateDoc(anuncioRef, {
              active: false,
              status: 'hidden'
            });
            setDatainEmail({
                email: userEmail,
                name: userName,
                userContacta: user.displayName
            })
            fetch("../../api/newoperationwhatsapp", {
                "method": "POST",
                "headers": { "content-type": "application/json" },
                "body": JSON.stringify(datainEmailRef.current)
            })
            }})
        }
        catch (e) {
            console.log("Error getting cached document:", e);
        }
        setTimeout(() => {
            router.push(`https://wa.me/${phone}`)
        }, 1000)
    }

    return (
        <section id='anuncios' className={`w-full flex md:flex-col flex-col ${styles.paddingY} xs:mt-20`}>
            {status == 'hidden' ?
             <div className='w-full flex flex-wrap bg-orange text-center font-montserrat items-center justify-center text-white'>Este anuncio está oculto: no aparecerá en el Mercado Cripto ya que está vinculado a una operación.</div>
             : 
             ''
            }
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
                            <Link href={`/market/perfil/${publisherPublicID}`}>
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
                        {operationsPunctuation !== '' ? <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}><span className='flex flex-wrap items-center justify-center text-orange'>{round((operationsPunctuation / totalOperations), 2)} <HiStar /></span> calificación promedio</li> :  <li className={`${styles.paragraph} text-white text-center flex flex-wrap items-center justify-center gap-1`}>¡Aún no recibió calificaciones!</li>}
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
                    {user.uid !== createdBy && phone !== null && phone !== '' &&
                    <button onClick={() => pressedButtonWhatsapp()} className={`px-8 bg-green-500 text-white cursor-pointer hover:text-green-500 hover:bg-white rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-full text-center py-[1rem] flex flex-wrap items-center justify-center gap-1`}><FaWhatsapp/> {contactado ? 'Contactado' : 'Contactar por WhatsApp'}</button>
                    }
                    {user.uid !== createdBy &&
                    <button onClick={() => pressedButton()} className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>{contactado ? 'Contactado' : 'Contactar'}</button>
                    }
                    {user.uid !== createdBy &&
                    <p onClick={() => setShowLogin(true)} className={` text-red-500 hover:text-white font-medium transition-all duration-300 ease-in-out flex flex-wrap items-center justify-center gap-1 cursor-pointer`}><MdWarningAmber />Reportar anuncio</p>
                    }
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