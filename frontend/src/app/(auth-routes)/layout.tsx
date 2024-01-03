import { getServerSession } from "next-auth";
import { ReactNode } from "react";
import { redirect } from "next/navigation";
import { nextAuthOptions } from "@/utils/authOptions";
import { Toaster } from "react-hot-toast";

interface PrivateLayoutProps {
	children: ReactNode
}

export default async function PrivateLayout({ children }: PrivateLayoutProps) {
	const session = await getServerSession(nextAuthOptions)

	if (session) {
		redirect('/home')
	}

	return (
		<>
			{children}
			<Toaster />
		</>
	)
}