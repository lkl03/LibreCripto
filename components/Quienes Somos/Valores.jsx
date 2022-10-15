import React from 'react'
import styles, { layout } from '../../styles/style'

const Valores = () => {
    return (
        <section id='faq' className={`flex flex-col ${styles.paddingY}`}>
            <div className='flex sm:flex-row flex-col flex-wrap justify-between mt-5 z-[1]'>
                <div className='flex flex-col m-auto items-start mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Nuestra idea</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>Transformar el modo en que se adquieren criptomonedas en la actualidad. Poder acercar el mundo cripto a toda persona que se interese por él, simplificando el acceso al dinero del futuro.</p>
                </div>
                <div className='flex flex-col m-auto items-end mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Fundación</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>LibreCripto surge a comienzos de 2021, como una tímida idea que fue creciendo a medida que se avanzaba en su desarrollo. Hoy en día constituimos un equipo que día a día trabaja con la premisa de ofrecer un mejor servicio para todos nuestros usuarios.</p>
                </div>
                <div className='flex flex-col m-auto items-start mt-5'>
                    <p className={`${styles.heading4} font-bold text-gradient text-center max-w-[470px]`}>Nuestros compromisos</p>
                    <p className={`${styles.paragraph} text-white text-center max-w-[470px] mt-5`}>Nos comprometemos a posibilitar el alcance del mundo cripto a toda persona, a transformar completamente el acceso de cualquier individuo a sus criptomonedas y ofreciendo, siempre, un servicio de calidad 100% gratuito.</p>
                </div>
            </div>
        </section>
    )
}

export default Valores