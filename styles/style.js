const styles = {
    boxWidth: "xl:max-w-[1280px] w-full",
  
    heading2: "font-montserrat font-semibold xs:text-[48px] text-[40px] text-white xs:leading-[76.8px] leading-[66.8px] w-full",
    heading3: "font-montserrat font-semibold xs:text-[36px] text-[30px] text-white xs:leading-[46.8px] leading-[36.8px] w-full",
    heading4: "font-montserrat font-semibold xs:text-[32px] text-[24px] text-white xs:leading-[36.8px] leading-[26.8px] w-full",
    paragraph: "font-montserrat font-normal text-[18px] leading-[30.8px]",
  
    flexCenter: "flex justify-center items-center",
    flexStart: "flex justify-center items-start",
  
    paddingX: "sm:px-12 px-6",
    paddingY: "sm:py-12 py-6",
    padding: "sm:px-12 px-6 sm:py-12 py-4",
  
    marginX: "sm:mx-16 mx-6",
    marginY: "sm:my-16 my-6",
  };
  
  export const layout = {
    section: `flex md:flex-row flex-col ${styles.paddingY}`,
    sectionReverse: `flex md:flex-row flex-col-reverse ${styles.paddingY}`,
  
    sectionImgReverse: `flex-1 flex ${styles.flexCenter} md:mr-10 mr-0 md:mt-0 mt-10 relative`,
    sectionImg: `flex-1 flex ${styles.flexCenter} md:ml-10 ml-0 md:mt-0 mt-10 relative`,
  
    sectionInfo: `flex-1 ${styles.flexStart} flex-col`,

    buttonWhite: `px-8 py-2.5 bg-white text-orange cursor-pointer hover:text-black rounded-xl font-monserrat font-semibold text-lg transition-all duration-300 ease-in-out`,
    buttonWhite2: `sm:px-10 px-8 sm:py-4 py-4 bg-white text-orange cursor-pointer hover:text-black rounded-2xl font-monserrat font-semibold sm:text-2xl text-xl transition-all duration-300 ease-in-out`,
    buttonOrange: `sm:px-16 px-12 sm:py-6 py-4 bg-orange text-white cursor-pointer hover:bg-white hover:text-orange rounded-2xl font-monserrat font-semibold sm:text-2xl text-xl transition-all duration-300 ease-in-out`,
    link: `text-white hover:text-orange transition-all duration-300 ease-in-out`,
    linkBlackHover: `text-white hover:text-black transition-all duration-300 ease-in-out`
  };
  
  export default styles;