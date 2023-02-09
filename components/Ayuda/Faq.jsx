import React from 'react'
import styles, { layout } from '../../styles/style'
import { criptoFaq, lcFaq, pfFaq, sitioFaq } from '../../constants'
import Link from 'next/link'

const Valores = () => {
    return (
        <section id='faq' className={`flex flex-col ${styles.paddingY}`}>
            <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>Preguntas frecuentes</h2>
            <p className={`${styles.heading3} font-medium text-start max-w-[470px]`} id="faq-librecripto">Sobre LibreCripto</p>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5'>
                {lcFaq.map((faq, index) => (
                    <div key={index} className='flex flex-col m-auto items-start mt-5'>
                        <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>{faq.title}</p>
                        <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>{faq.text}</p>
                    </div>
                ))}
            </div>
            <p className={`${styles.heading3} font-medium text-start max-w-[470px] mt-10`} id="faq-cripto">Sobre criptomonedas</p>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5'>
                {criptoFaq.map((faq, index) => (
                    <div key={index} className='flex flex-col m-auto items-start mt-5'>
                        <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>{faq.title}</p>
                        <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>{faq.text}</p>
                    </div>
                ))}
            </div>
            <p className={`${styles.heading3} font-medium text-start max-w-[470px] mt-10`} id="faq-p2pf2f">Sobre P2P y F2F</p>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5'>
                {pfFaq.map((faq, index) => (
                    <div key={index} className='flex flex-col m-auto items-start mt-5'>
                        <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>{faq.title}</p>
                        <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>{faq.text}</p>
                    </div>
                ))}
            </div>
            <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px] mt-10`}>Usuario y uso del sitio</h2>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5' id="faq-sitio">
                {sitioFaq.map((faq, index) => (
                    <div key={index} className='flex flex-col m-auto items-start mt-5'>
                        <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>{faq.title}</p>
                        <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>{faq.text}</p>
                    </div>
                ))}
            </div>
            <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px] mt-10`}>Legales</h2>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5 sm:gap-0 gap-5' id="legales">
                <div className='flex flex-col m-auto items-center mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Política de privacidad</p>
                    <button typeof='button' className='mt-10'>
                        <Link href={`../politica-de-privacidad`}>
                            <a className={`${layout.buttonWhite2}`}>
                            Leer
                            </a>
                        </Link>
                    </button>
                </div>
                <div className='flex flex-col m-auto items-center mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Términos y condiciones</p>
                    <button typeof='button' className='mt-10'>
                        <Link href={`../terminos-y-condiciones`}>
                            <a className={`${layout.buttonWhite2}`}>
                            Leer
                            </a>
                        </Link>
                    </button>
                </div>
            </div>
            <div className='flex sm:flex-row flex-col justify-center items-center w-full sm:mt-40 mt-20 mb-20 sm:mb-0'>
                <h2 className={`${styles.heading2}`}>¿No encontraste lo que buscabas?</h2>
                <button typeof='button' className='sm:w-[40%] w-full sm:mt-0 mt-10'>
                    <Link href={`../contacto`}>
                        <a className={`${layout.buttonWhite2}`}>
                            Contactanos
                        </a>
                    </Link>
                </button>
            </div>
        </section>
    )
}

export default Valores