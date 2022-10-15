import React from 'react'
import Link from 'next/link'
import styles, { layout } from '../../styles/style'

const Faq = () => {
    return (
        <section id='faq' className={`flex flex-col ${styles.paddingY}`}>
            
            <div className='flex flex-col justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[42px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Preguntas frecuentes</h1>
            </div>
            <div className='sm:mt-10 mt-5'>
                <div className='flex flex-col m-auto items-start mt-5'>
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Qué es LibreCripto?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te</p>
                </div>
                <div className='flex flex-col m-auto items-end mt-5'>
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Qué costo tiene <br /> usar LibreCripto?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te</p>
                </div>
                <div className='flex flex-col m-auto items-start mt-5'>
                    <p className={`${styles.heading3} font-bold text-gradient text-center max-w-[470px]`}>¿Cómo creo mi cuenta?</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod te</p>
                </div>
            </div>
            <button typeof='button' className='mt-10'>
                <Link href={`ayuda#faq-librecripto`}>
                    <a className={`${layout.buttonWhite2}`}>
                    Ver más
                    </a>
                </Link>
            </button>
        </section>
    )
}

export default Faq