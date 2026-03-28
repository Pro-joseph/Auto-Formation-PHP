"use client"

import Link from "next/link"
import { Github, Home, Mail } from "lucide-react"

export default function Navigation() {
  return (
    <nav className="fixed top-0 left-0 right-0 z-50 px-6 py-4 md:px-12 md:py-6">
      <div className="mx-auto flex max-w-7xl items-center justify-between">
        <Link
          href="#home"
          className="text-lg font-medium tracking-tight text-foreground transition-colors hover:text-primary"
        >
          Portfolio
        </Link>

        <div className="flex items-center gap-6 md:gap-8">
          <Link
            href="#home"
            className="group flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <Home className="h-4 w-4" />
            <span className="hidden md:inline">Home</span>
          </Link>

          <Link
            href="https://github.com"
            target="_blank"
            rel="noopener noreferrer"
            className="group flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <Github className="h-4 w-4" />
            <span className="hidden md:inline">GitHub</span>
          </Link>

          <Link
            href="#contact"
            className="group flex items-center gap-2 text-sm text-muted-foreground transition-colors hover:text-foreground"
          >
            <Mail className="h-4 w-4" />
            <span className="hidden md:inline">Contact</span>
          </Link>
        </div>
      </div>
    </nav>
  )
}
