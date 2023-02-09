import React from 'react'
import styles, { layout } from '../../styles/style'

const Intro = () => (
    <section id='intro' className={`flex flex-col ${styles.paddingY}`}>
        <div className={`flex-1 ${styles.flexStart} flex-col xl:px-0 sm:px-16 px-6`}>
            <div className='flex flex-column justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[52px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Contacto</h1>
            </div>
            <div className='flex flex-col m-auto items-center mt-5'>
                <p className={`${styles.paragraph} text-white text-center max-w-full`}>Estamos para darte una respuesta.</p>
            </div>
        </div>
    </section>
)
export default Intro