import React, { useEffect } from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'
import AOS from 'aos';
import 'aos/dist/aos.css';

const Faq = () => {
    useEffect(() => {
        AOS.init();
      }, []);
    return (
        <section id='faq' className={`flex flex-col ${styles.paddingY}`}>
            
            <div className='flex flex-col justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[42px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Preguntas frecuentes</h1>
            </div>
            <div className='sm:mt-10 mt-5'>
                <div className='flex flex-col m-auto items-start mt-5' data-aos="zoom-in">
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Qué es LibreCripto?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>LibreCripto es un sitio que ofrece a diferentes usuarios afines a la modalidad de comercio P2P y F2F la posibilidad de aumentar su acceso al mundo de las criptomonedas mediante un marketplace donde diferentes vendedores y operadores ofrecen operaciones para diferentes monedas.</p>
                </div>
                <div className='flex flex-col m-auto items-end mt-5' data-aos="zoom-in">
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Qué costo tiene <br /> usar LibreCripto?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Utilizar LibreCripto es y siempre será 100% gratuito para todos los usuarios.</p>
                </div>
                <div className='flex flex-col m-auto items-start mt-5' data-aos="zoom-in">
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Cómo creo mi cuenta?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Para registrarte y crear tu nueva cuenta, ingresá a la sección de <Link href='/acceder'><a className='text-orange hover:text-white transition-all duration-200 ease-in-out'>acceso</a></Link>. Podes registrarte usando tu cuenta de Google, Facebook o ingresando manualmente tus datos. ¡Así de simple y rápido!</p>
                </div>
            </div>
            <button typeof='button' className='mt-10'>
                <Link href={`ayuda#faq-librecripto`}>
                    <a target='_blank' className={`${layout.buttonWhite2}`}>
                    Ver más
                    </a>
                </Link>
            </button>
        </section>
    )
}

export default Faq