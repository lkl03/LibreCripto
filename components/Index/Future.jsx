import React, { useEffect } from 'react'
import styles, { layout } from '../../styles/style'
import { rectanglebgg } from '../../assets'
import AOS from 'aos';
import 'aos/dist/aos.css';

const Future = () => {
    useEffect(() => {
        AOS.init();
      }, []);

    return (
        <section id='future' className={`flex flex-col sm:pt-[3rem] sm: pb-[21rem] py-20 bg-no-repeat bg-cover`} style={{backgroundImage: `url(${rectanglebgg.src})`}}>
            <div className='flex flex-column justify-center items-center w-full paddingCustom mt-10 comprometidosText'>
                <h1 className='flex-1 font-montserrat font-bold text-center ss:text-[42px] text-[32px] text-white ss:leading-[65px] leading-[40px] mt-20'>Comprometidos con el <br className='sm:block hidden' /> {" "} <span className='text-white sm:text-black'>futuro</span>{" "}</h1>
            </div>
            <div className='flex flex-col m-auto items-center mt-5 paddingCustom'>
                <p className={`${styles.paragraph} text-white text-center max-w-[470px]`}>Las criptomonedas son la próxima gran revolución digital y en Librecripto nos comprometimos a brindar un servicio acorde a tales expectativas.</p>
                {/*<div className={`py-60 px-20 bg-white rounded-2xl mt-5`}>
                </div>
                
                */}
                    <div className={`flex-1 flex ${styles.flexCenter} sm:h-[640px] sm:min-h-[640px] w-full mt-5 relative`} data-aos="fade-up">
                    <video
                        src={require('../../assets/mainvideov2.mp4')}
                        type="video/mp4"
                        loop
                        controls={false}
                        muted
                        autoPlay
                        className="w-full h-full border-2 rounded-xl sm:border-orange border-white"
                    //style={{filter: 'grayscale(1)'}}
                    />
                </div>
            </div>
        </section>
    )
}

export default Future