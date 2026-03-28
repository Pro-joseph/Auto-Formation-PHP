"use client"

import { Github, Linkedin, Mail, Twitter } from "lucide-react"
import Link from "next/link"

const socialLinks = [
  { icon: Github, href: "https://github.com", label: "GitHub" },
  { icon: Linkedin, href: "https://linkedin.com", label: "LinkedIn" },
  { icon: Twitter, href: "https://twitter.com", label: "Twitter" },
  { icon: Mail, href: "mailto:hello@example.com", label: "Email" },
]

export default function ContactSection() {
  return (
    <section id="contact" className="relative min-h-screen px-6 py-24 md:px-12">
      <div className="mx-auto flex max-w-4xl flex-col items-center justify-center text-center">
        <p className="mb-4 text-sm uppercase tracking-widest text-muted-foreground">
          Get in Touch
        </p>
        <h2 className="mb-6 text-balance text-4xl font-bold tracking-tight text-foreground md:text-5xl lg:text-6xl">
          {"Let's work together"}
        </h2>
        <p className="mb-12 max-w-lg text-pretty text-base text-muted-foreground md:text-lg">
          {"I'm always open to discussing new projects, creative ideas, or opportunities to be part of your vision."}
        </p>

        <a
          href="mailto:hello@example.com"
          className="mb-16 inline-flex items-center gap-2 rounded-full bg-primary px-8 py-4 text-sm font-medium text-primary-foreground transition-all hover:scale-105 hover:bg-primary/90"
        >
          <Mail className="h-4 w-4" />
          Send me a message
        </a>

        <div className="flex items-center gap-6">
          {socialLinks.map(({ icon: Icon, href, label }) => (
            <Link
              key={label}
              href={href}
              target="_blank"
              rel="noopener noreferrer"
              className="group flex h-12 w-12 items-center justify-center rounded-full border border-border text-muted-foreground transition-all hover:border-primary hover:text-primary"
              aria-label={label}
            >
              <Icon className="h-5 w-5" />
            </Link>
          ))}
        </div>
      </div>

      <footer className="absolute bottom-8 left-0 right-0 text-center">
        <p className="text-xs text-muted-foreground">
          © {new Date().getFullYear()} Portfolio. All rights reserved.
        </p>
      </footer>
    </section>
  )
}
