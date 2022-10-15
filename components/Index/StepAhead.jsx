import React from 'react'
import styles, { layout } from '../../styles/style'
import { imgstepahead } from '../../assets'

const StepAhead = () => {
    return (
        <section id='features' className={`flex flex-col ${styles.paddingY}`}>
            <div className='flex flex-column justify-center items-center w-full'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[42px] text-[32px] text-white ss:leading-[75px] leading-[50px]'>Un paso adelante en la forma de adquirir <span className='text-gradient'> criptomonedas</span> <br className='sm:block hidden' /> {" "}</h1>
            </div>
            <div className='flex flex-col m-auto items-center mt-5 z-[1]'>
                <p className={`${styles.paragraph} text-white text-center max-w-[65%]`}>Hasta el momento, si alguien deseaba adquirir criptomonedas a cambio de dinero en efectivo, entraba en un proceso sumamente engorroso.</p>
                <p className={`${styles.paragraph} text-white text-center max-w-[65%] mt-5`}>Desde LibreCripto proponemos simplificar totalmente esta tarea: <br />
                Creando tu cuenta vas a poder acceder a los anuncios de cientos de usuarios interesados en comprar o vender cripto de manera P2P o F2F, <br />
                con la seguridad de poder verificar perfiles reputados y confiables, a través de calificaciones provistas por los propios usuarios de esta comunidad.
                </p>
            </div>
            <div className={`${layout.section} justify-evenly`}>
                <div className={`flex justify-between items-start mt-5 rounded-xl`}>
                    <div className='sm:w-[620px] w-full'>
                        <div className='md:absolute md:opacity-5 md:rotate-12 md:block hidden'>
                            <img src={imgstepahead.src} alt="img-stepahead" className='w-[75%] h-auto' />
                        </div>
                        <div>
                            <img src={imgstepahead.src} alt="img-stepahead" className='md:w-[50%] w-[75%] md:m-[0] m-auto h-auto' />
                        </div>
                    </div>
                </div>
                <div className='w-full'>
                    <div className={`flex justify-between items-center mt-5 flex-row`}>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                    </div>
                    <div className={`flex justify-between items-center mt-5 flex-row`}>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                        <div className='w-full border-2 rounded-xl border-orange card-info flex-basis-30'>
                            <p className={`${styles.paragraph} w-[95%] m-auto flex items-center text-center text-white mt-5`}></p>
                            <div className='p-1 rounded-br-lg rounded-bl-lg mt-5'>
                                <h2 className={`${styles.heading2} text-center xs:text-[36px] text-[30px]`}>F2F</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default StepAhead