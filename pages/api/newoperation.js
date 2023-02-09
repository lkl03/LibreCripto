import sgMail from '@sendgrid/mail'
import { NextApiRequest, NextApiResponse } from 'next';

sgMail.setApiKey(process.env.NEXT_PUBLIC_SENDGRID_APIKEY);

export default async (req = NextApiRequest, res = NextApiResponse) => {
  const { email, name, userContacta } = req.body
  const msg = {
    to: email,
    from: {
      email: 'librecripto@gmail.com',
      name: 'LibreCripto',
    },
    templateId: 'd-15f3f91e92c0429aadb85812ee125a4b',
    dynamic_template_data: {
      url: 'https://librecripto.com/acceder',
      support_email: 'librecripto@librecripto.com',
      main_url: 'https://librecripto.com',
      email,
      name,
      userContacta
    }
  };

  try {
    await sgMail.send(msg);
    res.json({ message: `Email has been sent` })
  } catch (error) {
    res.status(500).json({ error: 'Error sending email' })
  }
}