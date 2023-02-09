import sgMail from '@sendgrid/mail'
import { NextApiRequest, NextApiResponse } from 'next';

sgMail.setApiKey(process.env.NEXT_PUBLIC_SENDGRID_APIKEY);

export default async (req = NextApiRequest, res = NextApiResponse) => {
  const { email, name, userContacta, userContactado, rating, comentario } = req.body
  const msg = {
    to: email,
    from: {
      email: 'librecripto@gmail.com',
      name: 'LibreCripto',
    },
    templateId: 'd-e084feef52d84ca69f1054138ea27f01',
    dynamic_template_data: {
      url: 'https://librecripto.com/acceder',
      support_email: 'librecripto@librecripto.com',
      main_url: 'https://librecripto.com',
      email,
      name,
      userContacta,
      userContactado,
      rating,
      comentario
    }
  };

  try {
    await sgMail.send(msg);
    res.json({ message: `Email has been sent` })
  } catch (error) {
    res.status(500).json({ error: 'Error sending email' })
  }
}