"use client"

import { Canvas, useFrame } from "@react-three/fiber"
import { Float, MeshDistortMaterial, Environment } from "@react-three/drei"
import { useRef, useMemo } from "react"
import type { Mesh, Group } from "three"

function FloatingShape({
  position,
  color,
  scale = 1,
  speed = 1,
  distort = 0.3,
}: {
  position: [number, number, number]
  color: string
  scale?: number
  speed?: number
  distort?: number
}) {
  const meshRef = useRef<Mesh>(null)

  useFrame((state) => {
    if (meshRef.current) {
      meshRef.current.rotation.x = state.clock.elapsedTime * 0.2 * speed
      meshRef.current.rotation.y = state.clock.elapsedTime * 0.3 * speed
    }
  })

  return (
    <Float speed={2} rotationIntensity={0.5} floatIntensity={1}>
      <mesh ref={meshRef} position={position} scale={scale}>
        <icosahedronGeometry args={[1, 1]} />
        <MeshDistortMaterial
          color={color}
          distort={distort}
          speed={2}
          roughness={0.2}
          metalness={0.8}
        />
      </mesh>
    </Float>
  )
}

function FloatingTorus({
  position,
  color,
  scale = 1,
}: {
  position: [number, number, number]
  color: string
  scale?: number
}) {
  const meshRef = useRef<Mesh>(null)

  useFrame((state) => {
    if (meshRef.current) {
      meshRef.current.rotation.x = state.clock.elapsedTime * 0.1
      meshRef.current.rotation.z = state.clock.elapsedTime * 0.15
    }
  })

  return (
    <Float speed={1.5} rotationIntensity={0.3} floatIntensity={0.8}>
      <mesh ref={meshRef} position={position} scale={scale}>
        <torusGeometry args={[1, 0.4, 16, 32]} />
        <MeshDistortMaterial
          color={color}
          distort={0.2}
          speed={1.5}
          roughness={0.3}
          metalness={0.7}
        />
      </mesh>
    </Float>
  )
}

function SceneContent({ scrollProgress }: { scrollProgress: number }) {
  const groupRef = useRef<Group>(null)

  const shapes = useMemo(
    () => [
      { position: [-3, 2, -2] as [number, number, number], color: "#4ecdc4", scale: 0.8 },
      { position: [3, -1, -3] as [number, number, number], color: "#45b7d1", scale: 1.2 },
      { position: [0, 3, -4] as [number, number, number], color: "#96ceb4", scale: 0.6 },
      { position: [-2, -2, -2] as [number, number, number], color: "#88d8b0", scale: 0.9 },
    ],
    []
  )

  useFrame(() => {
    if (groupRef.current) {
      groupRef.current.rotation.y = scrollProgress * Math.PI * 0.5
      groupRef.current.position.y = scrollProgress * -2
    }
  })

  return (
    <group ref={groupRef}>
      {shapes.map((shape, i) => (
        <FloatingShape key={i} {...shape} speed={0.5 + i * 0.2} distort={0.2 + i * 0.1} />
      ))}
      <FloatingTorus position={[2, 1, -1]} color="#5dade2" scale={0.7} />
      <FloatingTorus position={[-1, -3, -3]} color="#76d7c4" scale={0.5} />
    </group>
  )
}

export default function Scene3D({ scrollProgress = 0 }: { scrollProgress?: number }) {
  return (
    <div className="fixed inset-0 -z-10">
      <Canvas camera={{ position: [0, 0, 8], fov: 50 }}>
        <Environment preset="night" />
        <ambientLight intensity={0.5} />
        <pointLight position={[10, 10, 10]} intensity={1} />
        <pointLight position={[-10, -10, -10]} intensity={0.5} color="#4ecdc4" />
        <SceneContent scrollProgress={scrollProgress} />
      </Canvas>
    </div>
  )
}
