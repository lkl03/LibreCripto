import React from 'react'
import styles, { layout } from '../../styles/style'

const Intro = () => (
    <section id='intro' className={`flex flex-col ${styles.paddingY}`}>
        <div className={`flex-1 ${styles.flexStart} flex-col xl:px-0 sm:px-16 px-6`}>
            <div className='flex flex-column justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[52px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Sobre nosotros</h1>
            </div>
            <div className='flex flex-col m-auto items-center mt-5'>
                <p className={`${styles.paragraph} text-white text-center sm:max-w-[50%] max-w-[95%]`}>Somos LibreCripto, nuestro principal objetivo es transformar el modo por el cual las personas acceden a las criptomonedas. <br /> Buscamos potenciar la posibilidad de acceder a la próxima era del dinero: <span className='text-gradient'>la era cripto.</span></p>
                <p className={`${styles.paragraph} text-white text-center sm:max-w-[50%] max-w-[95%]`}>Queremos y creemos posible multiplicar el alcance que las criptomonedas poseen sobre la vida común de cada individuo, acercando la próxima gran revolución tecnológica a la cotidianidad de cada uno de nosotros. Sobre tal premisa fundamos y preservamos nuestro proyecto.</p>
            </div>
        </div>
    </section>
)
export default Intro