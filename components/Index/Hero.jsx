import React, { useEffect } from 'react';
import styles, { layout } from '../../styles/style';
import { imghero } from '../../assets';
import Link from 'next/link';
import AOS from 'aos';
import 'aos/dist/aos.css';

const Hero = () => {
  useEffect(() => {
    AOS.init();
  }, []);

  return (
    <section id="home" className={`flex flex-col ${styles.paddingY}`}>
      <div className={`flex-1 ${styles.flexStart} flex-col xl:px-0 sm:px-16 px-6`}>
        <div className="flex flex-column justify-center items-center w-full">
          <h1 className="flex-1 font-montserrat font-bold text-center ss:text-[52px] text-[32px] text-white ss:leading-[75px] leading-[50px] z-[1]">
            Pasar de efectivo a <span className="text-gradient">cripto</span> <br className="sm:block hidden" /> nunca había sido tan fácil{" "}
          </h1>
          <div className="absolute w-[75%] h-[25%] bottom-[30%] orange__gradient" />
        </div>
        <div className="flex flex-col m-auto items-center mt-5 z-[1]">
          <p className={`${styles.paragraph} text-white text-center max-w-[870px]`}>
            Decile <span className="font-medium">hola</span> al mundo cripto. <br></br> Comerciá tus criptomonedas por P2P y F2F de la manera más simple, rápida y segura.
          </p>
          <button type="button" className="mt-10">
            <Link href={`acceder`}>
              <a className={`${layout.buttonOrange}`}>
                Empezar ahora
              </a>
            </Link>
          </button>
        </div>
      </div>

      <div className={`flex-1 flex ${styles.flexCenter} my-10 relative`}>
        <video
          src={require('../../assets/main-video.mp4')}
          type="video/mp4"
          loop
          controls={false}
          muted
          autoPlay
          className="w-full h-full object-cover border-2 rounded-xl sm:border-orange border-white"
          //style={{filter: 'grayscale(1)'}}
        />
      </div>

      <div className={`ss:hidden ${styles.flexCenter}`}></div>
    </section>
  );
};

export default Hero;