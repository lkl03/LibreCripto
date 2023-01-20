import sgMail from '@sendgrid/mail'
import { NextApiRequest, NextApiResponse } from 'next';

sgMail.setApiKey('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');

export default async (req = NextApiRequest, res = NextApiResponse) => {
  const { email, name, password } = req.body
  const msg = {
    to: email,
    from: {
      email: 'librecripto@gmail.com',
      name: 'LibreCripto',
    },
    templateId: 'd-15d8f85e1cd54a46ba9ed1e97e81d975',
    dynamic_template_data: {
      url: 'https://librecripto.com/acceder',
      support_email: 'librecripto@librecripto.com',
      main_url: 'https://librecripto.com',
      email,
      name,
      password
    }
  };

  try {
    await sgMail.send(msg);
    res.json({ message: `Email has been sent` })
  } catch (error) {
    res.status(500).json({ error: 'Error sending email' })
  }
}