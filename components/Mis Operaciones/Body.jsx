import { useContext, useEffect } from 'react'
import Link from 'next/link'
import { useRouter } from 'next/router'
import styles, { layout } from '../../styles/style'
import { AppContext } from '../AppContext'
import { HiSearch, HiOutlineRefresh } from 'react-icons/hi'
import { FaMapMarkerAlt, FaBitcoin, FaChevronDown, FaTimes, FaStar } from 'react-icons/fa'
import { collection, onSnapshot, getDocs, getDoc, doc, orderBy, query, where, getFirestore, deleteDoc, addDoc, setDoc, updateDoc, increment } from "firebase/firestore"
import { app } from '../../config'
import { useGeolocated } from "react-geolocated";
import { convertDistance, getPreciseDistance } from 'geolib'
import axios from "axios";
import { Circles } from 'react-loader-spinner'
import Moment from 'react-moment';
import 'moment/locale/es';
import { now } from 'moment'
import useState from 'react-usestateref'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { Rating } from 'react-simple-star-rating'
import Loader from '../Layout/Loader';

const Body = () => {
    let { user, logout } = useContext(AppContext)

    const router = useRouter();

    const [operaciones, setOperaciones] = useState([])
    const [operacionesActive, setOperacionesActive] = useState([])
    const [operacionesAll, setOperacionesAll] = useState([])
    const [calificaciones, setCalificaciones] = useState([])
    const [contacta, setContacta] = useState({})
    const [calificacionesContacta, setCalificacionesContacta] = useState({})
    const [contactado, setContactado] = useState({})
    const [calificacionesContactado, setCalificacionesContactado] = useState({})
    const [loading, setLoading] = useState(true)
    const [calificacionesLoading, setCalificacionesLoading] = useState(true)
    const [deletePrompt, setDeletePrompt] = useState(false)
    const [userContactaDeletePrompt, setUserContactaDeletePrompt] = useState(false)
    const [calificarUsuario, setCalificarUsuario] = useState(false)
    const [userContactaCalificarUsuario, setUserContactaCalificarUsuario] = useState(false)
    const [showOperationSummary, setShowOperationSummary] = useState(false)
    const [userContactaShowOperationSummary, setUserContactaShowOperationSummary] = useState(false)
    const [operacionID, setOperacionID] = useState('')
    const [operacionAnuncio, setOperacionAnuncio, operacionAnuncioRef] = useState('')
    const [userContacta, setUserContacta, userContactaRef] = useState('')
    const [userContactaID, setUserContactaID, userContactaIDRef] = useState('')
    const [userContactado, setUserContactado, userContactadoRef] = useState('')
    const [userContactadoID, setUserContactadoID, userContactadoIDRef] = useState('')
    const [userContactaEmail, setUserContactaEmail, userContactaEmailRef] = useState('')
    const [userContactadoEmail, setUserContactadoEmail, userContactadoEmailRef] = useState('')
    const [rating, setRating, ratingRef] = useState(0)
    const [comentario, setComentario, comentarioRef] = useState('');
    const [userContactaRating, setUserContactaRating, userContactaRatingRef] = useState(0)
    const [userContactaComentario, setUserContactaComentario, userContactaComentarioRef] = useState('');
    const [datainEmail, setDatainEmail, datainEmailRef] = useState({
        email: '',
        name: '',
        userContacta: '',
        userContactado: '',
        rating: '',
        comentario: ''
    })
    const [userContactaDatainEmail, setUserContactaDatainEmail, userContactaDatainEmailRef] = useState({
        email: '',
        name: '',
        userContacta: '',
        userContactado: '',
        rating: '',
        comentario: ''
    })
    const options = [
        { value: 'Activas', text: 'Activas' },
        { value: 'Completadas', text: 'Completadas' },
    ];
    const [selected, setSelected, selectedRef] = useState(options[0].value);
    const [state, setState, stateRef] = useState()

    useEffect (() => {
        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
        console.log(selected)
        if (selectedRef.current == 'Activas') {
            setState(true)
        } else if (selectedRef.current == 'Completadas') {
            setState(false)
        }
        const getOperaciones = async () => {
            const itemsRef = query(collection(db, "operaciones"), where('active', '==', stateRef.current));
            const querySnapshot = await getDocs(itemsRef);
            const contactaUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContacta))];
            console.log(contactaUids);
            const contactaDocs = await Promise.all(contactaUids.map(uid => getDoc(doc(db, "users", uid))));
            const contactaField = contactaDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
            const contactadoUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactado))];
            const contactadoDocs = await Promise.all(contactadoUids.map(uid => getDoc(doc(db, "users", uid))));
            const contactadoField = contactadoDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
            let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
            data = data.filter(
              doc => doc.userContacta === userInfo?.uid || doc.userContactado === userInfo?.uid
            );
            setOperaciones(data);
            console.log(data);
            setContacta(contactaField);
            setContactado(contactadoField);
            setLoading(false);
            console.log(operaciones);
        }

        getOperaciones()
    }, [selected])

    const db = getFirestore(app);

    const handleRating = (rate) => {
        setRating(rate);
        console.log(rate)
        console.log(ratingRef.current)
    };

    const handleComentario = (e) => {
        setComentario(e.target.value);
        console.log(e.target.value);
        console.log(comentarioRef.current)
    }

    const userContactaHandleRating = (rate) => {
        setUserContactaRating(rate);
        console.log(rate)
        console.log(ratingRef.current)
    };

    const userContactaHandleComentario = (e) => {
        setUserContactaComentario(e.target.value);
        console.log(e.target.value);
        console.log(comentarioRef.current)
    }

    useEffect(() => {

        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()

        const getOperaciones = async () => {
            const itemsRef = query(collection(db, "operaciones"), where('active', '==', true));
            const querySnapshot = await getDocs(itemsRef);
            const contactaUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContacta))];
            console.log(contactaUids);
            const contactaDocs = await Promise.all(contactaUids.map(uid => getDoc(doc(db, "users", uid))));
            const contactaField = contactaDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
            const contactadoUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactado))];
            const contactadoDocs = await Promise.all(contactadoUids.map(uid => getDoc(doc(db, "users", uid))));
            const contactadoField = contactadoDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
            let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
            data = data.filter(
              doc => doc.userContacta === userInfo?.uid || doc.userContactado === userInfo?.uid
            );
            setOperaciones(data);
            setOperacionesActive(data)
            console.log(data);
            setContacta(contactaField);
            setContactado(contactadoField);
            setLoading(false);
            console.log(operaciones);
        }

        getOperaciones()

        const getCalificaciones = async () => {
            const itemsRef = query(collection(db, 'calificaciones'), orderBy('userContactaFinishTime', 'desc'))
            const querySnapshot = await getDocs(itemsRef)
            const contactaUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactaID))]
            const contactaDocs = await Promise.all(contactaUids.map(uid => getDoc(doc(db, 'users', uid))))
            const contactaField = contactaDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            const contactadoUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactadoID))]
            const contactadoDocs = await Promise.all(contactadoUids.map(uid => getDoc(doc(db, 'users', uid))))
            const contactadoField = contactadoDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {})
            let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
            data = data.filter(
              doc => doc.userContactaID === userInfo?.uid || doc.userContactadoID === userInfo?.uid
            );            
            setCalificaciones(data)
            setCalificacionesLoading(false)
            setCalificacionesContacta(contactaField)
            setCalificacionesContactado(contactadoField)
            console.log(calificaciones)
        }

        getCalificaciones()

        const operacionesTotal = async () => {
            const itemsRef = query(collection(db, "operaciones"), where('status', '==', 'Completada'));
            const querySnapshot = await getDocs(itemsRef);
            const contactaUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContacta))];
            console.log(contactaUids);
            const contactadoUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactado))];
            let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
            data = data.filter(
              doc => doc.userContacta === userInfo?.uid || doc.userContactado === userInfo?.uid
            );
            setOperacionesAll(data);
            console.log(data);
            setLoading(false);
            console.log(operaciones);
        }

        operacionesTotal()
    }, [])

    const refreshAnuncios = async () => {
        const userInfo = localStorage.getItem('user') !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : localStorage.clear()
        setLoading(true)
        const itemsRef = query(collection(db, "operaciones"), where('active', '==', true));
        const querySnapshot = await getDocs(itemsRef);
        const contactaUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContacta))];
        console.log(contactaUids);
        const contactaDocs = await Promise.all(contactaUids.map(uid => getDoc(doc(db, "users", uid))));
        const contactaField = contactaDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
        const contactadoUids = [...new Set(querySnapshot.docs.map(doc => doc.data().userContactado))];
        const contactadoDocs = await Promise.all(contactadoUids.map(uid => getDoc(doc(db, "users", uid))));
        const contactadoField = contactadoDocs.reduce((acc, doc) => ({ ...acc, [doc.id]: doc.data() }), {});
        let data = querySnapshot.docs.map(doc => ({ ...doc.data(), id: doc.id }));
        data = data.filter(
          doc => doc.userContacta === userInfo?.uid || doc.userContactado === userInfo?.uid
        );
        setOperaciones(data);
        console.log(data);
        setContacta(contactaField);
        setContactado(contactadoField);
        setLoading(false);
        console.log(operaciones);
    }

    const { coords, isGeolocationAvailable, isGeolocationEnabled } =
        useGeolocated({
            positionOptions: {
                enableHighAccuracy: false,
            },
            userDecisionTimeout: 5000,
        });

    const showDeletePrompt = (value) => {
        setDeletePrompt(true);
        setOperacionID(value);
        const operacion = operaciones.find(o => o.id === value);
        setUserContacta(contacta[operacion.userContacta]?.name);
        setUserContactaID(contacta[operacion.userContacta]?.uid);
        console.log(userContactaRef.current);
        setUserContactado(contactado[operacion.userContactado]?.name);
        setUserContactadoID(contactado[operacion.userContactado]?.uid);
        console.log(userContactadoRef.current);
        setOperacionAnuncio(operacion.anuncio);
        console.log(operacionAnuncioRef.current);
        setUserContactaEmail(contacta[operacion.userContacta]?.email);
        console.log(userContactaEmailRef.current);
        setUserContactadoEmail(contactado[operacion.userContactado]?.email);
        console.log(userContactadoEmailRef.current);
    };

    const showUserContactaDeletePrompt = (value) => {
        setUserContactaDeletePrompt(true);
        setOperacionID(value);
        const operacion = operaciones.find(o => o.id === value);
        setUserContacta(contacta[operacion.userContacta]?.name);
        setUserContactaID(contacta[operacion.userContacta]?.uid);
        console.log(userContactaRef.current);
        setUserContactado(contactado[operacion.userContactado]?.name);
        setUserContactadoID(contactado[operacion.userContactado]?.uid);
        console.log(userContactadoRef.current);
        setOperacionAnuncio(operacion.anuncio);
        console.log(operacionAnuncioRef.current);
        setUserContactaEmail(contacta[operacion.userContacta]?.email);
        console.log(userContactaEmailRef.current);
        setUserContactadoEmail(contactado[operacion.userContactado]?.email);
        console.log(userContactadoEmailRef.current);
    };

    const finishOperacion = () => {
        console.log(operacionID)
        const operacionRef = doc(db, "operaciones", operacionID);
        updateDoc(operacionRef, {
          status: `Esperando confirmación de ${userContactadoRef.current}`
        });
        setDeletePrompt(false)
        setCalificarUsuario(true)
    }

    const finishOperacionUserContacta = () => {
        console.log(operacionID)
        const operacionRef = doc(db, "operaciones", operacionID);
        updateDoc(operacionRef, {
          status: `Finalizando...`
        });
        setUserContactaDeletePrompt(false)
        setUserContactaCalificarUsuario(true)
    }

    const returnToFinishOperacion = () => {
        setCalificarUsuario(false)
        setDeletePrompt(true)
        setComentario('')
    }

    const userContactaReturnToFinishOperacion = () => {
        setUserContactaCalificarUsuario(false)
        setUserContactaDeletePrompt(true)
        setComentario('')
    }

    const sendCalificacion = () => {
        try {
            const q = query(collection(db, "calificaciones"), where("operacion", "==", operacionID));
            getDocs(q).then(res => {
            if (res.docs.length === 0) {
            setDoc(doc(db, "calificaciones", operacionID), {
                createdAt: now(),
                operacion: operacionID,
                anuncio: operacionAnuncioRef.current,
                userContacta: userContactaRef.current,
                userContactaID: userContactaIDRef.current,
                userContactado: userContactadoRef.current,
                userContactadoID: userContactadoIDRef.current,
                userContactadoFinishTime: now(),
                userContactaFinishTime: '',
                calificacionParaUserContacta: parseFloat(ratingRef.current),
                comentarioParaUserContacta: comentarioRef.current,
                calificacionParaUserContactado: '',
                comentarioParaUserContactado: ''
            })
            const operacionRef = doc(db, "operaciones", operacionID);
            updateDoc(operacionRef, {
                status: `Esperando calificación de ${userContactaRef.current}`
              });
            const getUserRef = doc(db, "users", userContactaIDRef.current);
            updateDoc(getUserRef, {
                lastOperationDate: now(),
                });
            updateDoc(getUserRef, {
                totalOperations: increment(1),
                operationsPunctuation: increment(parseFloat(ratingRef.current))
            })
            setDatainEmail({
                email: userContactaEmailRef.current,
                name: user.displayName,
                userContacta: userContactaRef.current,
                userContactado: userContactadoRef.current,
                rating: ratingRef.current,
                comentario: comentarioRef.current
            })
            fetch("../../api/newcalificacion", {
                "method": "POST",
                "headers": { "content-type": "application/json" },
                "body": JSON.stringify(datainEmailRef.current)
            })
            setCalificarUsuario(false)
            setShowOperationSummary(true)
            }})
        }
        catch (e) {
            console.log("Error getting cached document:", e);
        }
    }

    const userContactaSendCalificacion = () => {
        try {
            const calificacionRef = doc(db, "calificaciones", operacionID);
            updateDoc(calificacionRef, {
                calificacionParaUserContactado: parseFloat(userContactaRatingRef.current),
                comentarioParaUserContactado: userContactaComentarioRef.current,
                userContactaFinishTime: now()
              });
            const operacionRef = doc(db, "operaciones", operacionID);
            updateDoc(operacionRef, {
                status: 'Completada',
                finishedAt: now(),
                active: false
              });
              const getUserRef = doc(db, "users", userContactadoIDRef.current);
              updateDoc(getUserRef, {
                  lastOperationDate: now(),
                  });
                  updateDoc(getUserRef, {
                  totalOperations: increment(1),
                  operationsPunctuation: increment(parseFloat(userContactaRatingRef.current))
              })
            setUserContactaDatainEmail({
                email: userContactadoEmailRef.current,
                name: user.displayName,
                userContacta: userContactaRef.current,
                userContactado: userContactadoRef.current,
                rating: userContactaRatingRef.current,
                comentario: userContactaComentarioRef.current
            })
            fetch("../../api/operacioncompletada", {
                "method": "POST",
                "headers": { "content-type": "application/json" },
                "body": JSON.stringify(userContactaDatainEmailRef.current)
            })
            setUserContactaCalificarUsuario(false)
            setUserContactaShowOperationSummary(true)
        }
        catch (e) {
            console.log("Error getting cached document:", e);
        }
    }

    const reloadAfterCalificacion = () => {
        setShowOperationSummary(false)
        setUserContactaShowOperationSummary(false)
        setTimeout(() => {
            router.reload()
        }, 500)
    }

    return (
        <section id='operaciones' className={`flex md:flex-row flex-col md:items-center ${styles.paddingY} xs:mt-20`}>
            <ToastContainer />
            {deletePrompt ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¿Seguro querés finalizar esta operación?</p>
                        <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Por favor finalizá la operación solo cuando hayas completado el intercambio con <span className='text-orange'>{userContactaRef.current}</span></p>
                        <div className='w-full mt-5 mb-5 flex gap-10 items-center justify-center'>
                            <button type='button' onClick={() => finishOperacion()} className={`px-8 bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Sí, finalizar</a>
                            </button>
                            <button type='button' onClick={() => setDeletePrompt(false)} className={`px-8 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>No, volver</a>
                            </button>
                        </div>
                    </div>
                </div> 
            :
            ''
            }
            {userContactaDeletePrompt ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¿Seguro querés finalizar esta operación?</p>
                        <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Por favor finalizá la operación solo cuando hayas recibido la calificación de <span className='text-orange'>{userContactadoRef.current}</span></p>
                        <div className='w-full mt-5 mb-5 flex gap-10 items-center justify-center'>
                            <button type='button' onClick={() => finishOperacionUserContacta()} className={`px-8 bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Sí, finalizar</a>
                            </button>
                            <button type='button' onClick={() => setUserContactaDeletePrompt(false)} className={`px-8 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>No, volver</a>
                            </button>
                        </div>
                    </div>
                </div> 
            :
            ''
            }
            {calificarUsuario ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¿Cómo calificás a <span className='text-orange'>{userContactaRef.current}</span>?</p>
                        <div>
                            <Rating
                                onClick={handleRating}
                                transition={true}
                                SVGclassName='inline-block'
                                allowFraction={true}
                            />
                        </div>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regdesc" className='text-white font-normal text-start mt-5'>Dejá un breve comentario sobre tu experiencia con este usuario.</label>
                            <textarea id='regdesc' name='regdesc' autoComplete="desc" onChange={handleComentario} value={comentario} maxLength={460} className='input p-3 text-white outline-none'></textarea>
                        </div>
                        <div className='w-full mt-5 mb-5 flex gap-10 items-center justify-center'>
                            <button type='button' onClick={() => sendCalificacion()} className={`px-8 bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Calificar</a>
                            </button>
                            <button type='button' onClick={() => returnToFinishOperacion(false)} className={`px-8 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Volver</a>
                            </button>
                        </div>
                    </div>
                </div> 
            :
            ''
            }
            {userContactaCalificarUsuario ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¿Cómo calificás a <span className='text-orange'>{userContactadoRef.current}</span>?</p>
                        <div>
                            <Rating
                                onClick={userContactaHandleRating}
                                transition={true}
                                SVGclassName='inline-block'
                                allowFraction={true}
                            />
                        </div>
                        <div className='flex flex-col flex-wrap w-[90%] gap-2'>
                            <label htmlFor="regdesc" className='text-white font-normal text-start mt-5'>Dejá un breve comentario sobre tu experiencia con este usuario.</label>
                            <textarea id='regdesc' name='regdesc' autoComplete="desc" onChange={userContactaHandleComentario} value={userContactaComentario} maxLength={460} className='input p-3 text-white outline-none'></textarea>
                        </div>
                        <div className='w-full mt-5 mb-5 flex gap-10 items-center justify-center'>
                            <button type='button' onClick={() => userContactaSendCalificacion()} className={`px-8 bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Calificar</a>
                            </button>
                            <button type='button' onClick={() => userContactaReturnToFinishOperacion(false)} className={`px-8 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out w-[40%] py-[0.5rem] mt-5`}>
                                <a>Volver</a>
                            </button>
                        </div>
                    </div>
                </div> 
            :
            ''
            }
            {showOperationSummary ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                        <FaTimes onClick={() => reloadAfterCalificacion()} />
                    </div>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Calificación enviada!</p>
                        <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Enviamos un aviso a <span className='text-orange'>{userContactaRef.current}</span> para que te califique. Una vez que lo haga, te enviaremos un email y la operación estará completada.</p>
                    </div>
                </div> 
            :
            ''
            }
            {userContactaShowOperationSummary ?
                <div className={`absolute flex flex-col justify-center items-center top-0 right-0 left-0 bottom-0 bg-blackOverlay z-[2]`}>
                    <div className='relative top-[6vh] xl:left-[14vw] lg:left-[18vw] md:left-[24vw] sm:left-[26vw] left-[40vw] text-white text-4xl cursor-pointer z-[1]'>
                        <FaTimes onClick={() => reloadAfterCalificacion()} />
                    </div>
                    <div className='sm:w-[620px] w-[95%] border-2 rounded-xl border-orange popup flex flex-col text-center items-center justify-center'>
                        <p className={`${styles.paragraph} w-[95%] m-auto text-center text-white mt-5`}>¡Operación completada!</p>
                        <p className={`${styles.paragraph} sm:w-[95%] w-[65%] m-auto font-medium text-center text-white`}>Ya notificamos a <span className='text-orange'>{userContactadoRef.current}</span> sobre tu calificación. ¡La operación fue completada correctamente!</p>
                    </div>
                </div> 
            :
            ''
            }
            <div className={`flex flex-col md:w-[70%] w-full ${styles.paddingY}`}>
                <div className={`w-[100%] flex md:flex-row flex-col-reverse flex-wrap items-center justify-start gap-4 mt-5`}>
                    <div className='flex flex-wrap md:w-[97%] w-[100%] justify-evenly border-2 rounded-xl sm:border-orange border-white'>
                        <div className='flex flex-wrap m-4'>
                            <div className='flex flex-wrap items-center justify-between gap-2 border-b px:4'>
                                {/*<FaChevronDown className='text-xl text-white' />*/}
                                <p className={`${styles.paragraph} text-center text-white sm:text-[17px] text-sm`}>Mostrar operaciones</p>
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
                </div>
                <div className='flex flex-col flex-wrap justify-between'>
                    <div className={`flex flex-col items-start justify-start mt-5`}>
                        <div className='flex flex-wrap md:w-[97%] w-[100%] md:h-[410px] h-auto border-2 rounded-tr-lg rounded-tl-lg sm:border-orange border-white max-h-[410px] overflow-y-scroll overflow-x-hidden'>
                            {loading
                                ?
                                <div className='mx-auto mt-4'><Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /></div>
                                :
                                operaciones.map(operacion => (
                                    <div className='sm:w-[50%] w-[100%]'>
                                        <div key={operacion.id} className='w-[100%]'>
                                            <div className='w-[100%]'>
                                                <div className='border-2 rounded-xl border-orange card-anuncio m-4'>
                                                    <div className='flex flex-wrap p-6 items-start justify-between gap-2'>
                                                        <div className='flex flex-wrap items-center gap-2'>
                                                            <div className="rounded-full h-11 w-11 profile-icon">
                                                                <img className='rounded-full' src=
                                                                    {user.uid == operacion.userContacta
                                                                        ?
                                                                        (contactado[operacion.userContactado]?.image !== null && contactado[operacion.userContactado]?.image !== '' ? contactado[operacion.userContactado]?.image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg')
                                                                        :
                                                                        (contacta[operacion.userContacta]?.image !== null && contacta[operacion.userContacta]?.image !== '' ? contacta[operacion.userContacta]?.image : 'https://i.pinimg.com/originals/65/25/a0/6525a08f1df98a2e3a545fe2ace4be47.jpg')}
                                                                    alt="" />
                                                            </div>
                                                            <div className='flex-col flex-wrap justify-center items-center'>
                                                                {operacion.status !== 'Completada' ?
                                                                    <p className={`font-montserrat font-normal text-sm text-center text-white italic`}>Creada <Moment fromNow locale="es">{operacion.createdAt}</Moment></p>
                                                                    :
                                                                    <p className={`font-montserrat font-normal text-sm text-center text-white italic`}>Finalizada <Moment fromNow locale="es">{operacion.finishedAt}</Moment></p>
                                                                }
                                                                {user.uid == operacion.userContacta
                                                                    ?
                                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>Contactaste a <Link href={`../market/perfil/${contactado[operacion.userContactado]?.publicID}`}><a target="_blank" className='hover:text-orange transition-all duration-200 ease-in-out'>{contactado[operacion.userContactado]?.name}</a></Link></p>
                                                                    :
                                                                    <p className={`${styles.paragraph} text-center text-white font-medium`}>Te contactó <Link href={`perfil/${contacta[operacion.userContacta]?.publicID}`}><a target="_blank" className='hover:text-orange transition-all duration-200 ease-in-out'>{contacta[operacion.userContacta]?.name}</a></Link></p>
                                                                }
                                                                <p className={`font-montserrat font-normal text-sm text-center text-white`}>Estado: <br></br> <span className='text-orange italic'>{operacion.status}</span></p>
                                                                <div className='flex flex-wrap items-center justify-center mt-5'>
                                                                <Link href={`../market/anuncio/${operacion.anuncio}`}>
                                                                    <a target="_blank" className='font-montserrat font-medium text-normal text-center text-white hover:text-orange transition-all duration-200 ease-in-out'>Ver Anuncio</a>
                                                                </Link>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className='flex flex-wrap px-6 justify-around items-center gap-2'></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className='flex flex-wrap justify-center items-center'>
                                            {user?.uid == operacion.userContacta && operacion.status == 'En curso' &&
                                                <div className='flex flex-wrap items-center justify-between gap-2'>
                                                    <Circles height="30" width="30" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} />
                                                    <p className={`font-montserrat font-medium text-center text-white`}>Esperando que <br></br> <span className='text-orange'>{contactado[operacion.userContactado]?.name}</span> te califique</p>
                                                </div>
                                            }
                                            {user?.uid == operacion.userContactado && operacion.status == 'En curso' &&
                                                <button type='button' onClick={() => showDeletePrompt(operacion.id)} className={`${layout.buttonWhite} text-center`}>Finalizar operación</button>
                                            }
                                            {user?.uid == operacion.userContacta && operacion.status == `Esperando calificación de ${contacta[operacion.userContacta]?.name}` &&
                                                <button type='button' onClick={() => showUserContactaDeletePrompt(operacion.id)} className={`${layout.buttonWhite} text-center`}>Finalizar operación</button>   
                                            }
                                            {user?.uid == operacion.userContactado && operacion.status == `Esperando calificación de ${contacta[operacion.userContacta]?.name}` &&
                                                <div className='flex flex-wrap items-center justify-between gap-2'>
                                                    <Circles height="30" width="30" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} />
                                                    <p className={`font-montserrat font-medium text-center text-white`}>Esperando que <br></br> <span className='text-orange'>{contacta[operacion.userContacta]?.name}</span> finalice la operación</p>
                                                </div>
                                            }
                                        </div>
                                    </div>
                                ))}
                        </div>
                        {loading ? '' : <div className='flex items-center justify-center sm:bg-orange bg-white rounded-br-lg rounded-bl-lg card-info--title md:w-[97%] w-[100%]'>
                            <HiOutlineRefresh className='md:text-white text-orange hover:text-black text-3xl m-4 cursor-pointer transition-all duration-300 ease-in-out' onClick={() => refreshAnuncios()} />
                        </div>}
                    </div>
                    <div className='flex flex-wrap md:w-[97%] w-[100%] items-center justify-around md:mt-auto mt-4 gap-2'>
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
            <div className='flex flex-col md:w-[30%] w-[100%] justify-between gap-4'>
            <div className='flex flex-col w-[100%] items-center justify-center'>

                <div className='flex flex-wrap items-center justify-center border-2 rounded-xl sm:border-orange border-white max-h-[410px]'>
                    <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Estadísticas</p>
                    </div>
                    <div className='overflow-y-scroll overflow-x-hidden md:max-h-[85%]'>
                        <ul className='${styles.paragraph} text-center sm:text-white text-orange sm:text-xl mt-4 mb-4'>
                            <li><span className='font-medium text-orange'>{operacionesActive.length}</span> Operaciones activas</li>
                            <li><span className='font-medium text-orange'>{operacionesAll.length}</span> Operaciones completadas</li>
                            <li><span className='font-medium text-orange'>{calificaciones.length}</span> Calificaciones recibidas</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div className='flex flex-col w-[100%] items-center justify-center'>
            <div className='flex flex-wrap items-center justify-center border-2 rounded-xl sm:border-orange border-white max-h-[410px]'>
                    <div className='w-full sm:bg-orange bg-white rounded-tr-lg rounded-tl-lg card-info--title'>
                        <p className={`${styles.paragraph} text-center sm:text-white text-orange sm:text-xl font-medium mt-4 mb-4`}>Calificaciones recibidas</p>
                    </div>
                    <div className='overflow-y-scroll overflow-x-hidden md:max-h-[125px]'>
                    {calificaciones.length == '0' ? <p className={`${styles.paragraph} text-center sm:text-white text-orange font-medium mt-4 mb-4`}>¡Aún no recibiste calificaciones!</p>: ''}
                    {calificacionesLoading ? 
                        <div className='mx-auto mt-4'><Circles height="70" width="70" color="#fe9416" ariaLabel="circles-loading" wrapperStyle={{}} wrapperClass="" visible={true} /></div>
                    :
                        calificaciones.map(calificacion => (
                            <ul className='${styles.paragraph} text-center sm:text-white text-orange mt-4 mb-4'>
                                {calificacion.userContactaID == user?.uid &&
                                    <div>
                                        <p className='text-gray-500'><Moment fromNow locale="es">{calificacion.userContactadoFinishTime}</Moment></p>
                                        <div>Te calificó: <Link href={`../market/perfil/${calificacionesContactado[calificacion.userContactadoID]?.publicID}`}><a target="_blank" className='hover:text-orange transition-all duration-200 ease-in-out'>{calificacion.userContactado}</a></Link></div>
                                        <div className='inline-flex items-center justify-center gap-1'><p>Recibiste: {calificacion.calificacionParaUserContacta}</p><FaStar color='#fe9416'/></div>
                                        <p>Comentario: <span className='italic'>"{calificacion.comentarioParaUserContacta}"</span></p>
                                    </div>
                                }
                                {calificacion.userContactadoID == user.uid &&
                                    <div>
                                    <p className='text-gray-500'><Moment fromNow locale="es">{calificacion.userContactaFinishTime}</Moment></p>
                                    <div>Te calificó: <Link href={`../market/perfil/${calificacionesContacta[calificacion.userContactaID]?.publicID}`}><a target="_blank" className='hover:text-orange transition-all duration-200 ease-in-out'>{calificacion.userContacta}</a></Link></div>
                                        <div className='inline-flex items-center justify-center gap-1'><p>Recibiste: {calificacion.calificacionParaUserContactado}</p><FaStar color='#fe9416'/></div>
                                        <p>Comentario: <span className='italic'>"{calificacion.comentarioParaUserContactado}"</span></p>
                                    </div>
                                }
                            </ul>
                        ))
                    }
                    </div>
                </div>
                <div className='md:w-[auto] w-full md:block flex items-center md:mt-[2rem] mt-4'>
                    <Link href="/market/mi-perfil">
                        <a className={`${layout.buttonWhite} w-full text-center py-[1rem]`}>
                            Ver mi perfil
                        </a>
                    </Link>
                </div>
            </div>
            </div>
        </section>
    )
}

export default Body