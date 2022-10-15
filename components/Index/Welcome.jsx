import React from 'react'
import styles, { layout } from '../../styles/style'

const Welcome = () => {
    return (
        <section id='features' className={`flex flex-col ${styles.paddingY}`}>
            <div className='flex flex-column justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[42px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Bienvenido al <span className='text-gradient'> mundo cripto</span> <br className='sm:block hidden' /> {" "} Bienvenido al <span className='text-gradient'>P2P</span>, bienvenido al <span className='text-gradient'>F2F</span>{" "}</h1>
            </div>
            <div className={`${layout.section} justify-between`}>
                <div className={`${layout.sectionInfo} mt-5`}>
                    <div className='sm:w-[620px] w-full border-2 rounded-xl border-orange card-info'>
                        <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}>El comercio peer-to-peer es la forma más efectiva para ingresar al mercado de las criptomonedas. La esencia del mismo radica en su descentralización, lo que garantiza un intercambio directo entre dos partes interesadas en llevar adelante la operación.</p>
                        <div className='p-1 bg-orange rounded-br-lg rounded-bl-lg card-info--title mt-5'>
                            <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>P2P</h2>
                        </div>
                    </div>
                </div>
                <div className={`${layout.sectionInfo} mt-5`}>
                    <div className='sm:w-[620px] w-full border-2 rounded-xl border-orange card-info'>
                        <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}>El comercio face-to-face supone dar un paso más adelante en esta operativa. Además de ser descentralizado, garantiza el total anonimato del acuerdo entre partes, respetando el motivo originario de las criptomonedas.</p>
                        <div className='p-1 bg-orange rounded-br-lg rounded-bl-lg card-info--title mt-5'>
                            <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default Welcome