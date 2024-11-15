import { Bell, ChevronDown, LayoutDashboard, FileText, History, User, Settings, LogOut } from 'lucide-react'
import { Button } from "@/components/ui/button"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar"

export default function Component() {
  return (
    <div className="min-h-screen bg-gray-100">
      {/* Header */}
      <header className="bg-red-600 text-white p-4">
        <div className="container mx-auto flex items-center justify-between">
          <div className="flex items-center space-x-4">
            <Image
              src="/placeholder.svg?height=40&width=40"
              alt="Logo"
              width={40}
              height={40}
              className="rounded-full bg-white"
            />
            <h1 className="text-2xl font-serif">Scholarship Tracker System</h1>
          </div>
          <div className="flex items-center space-x-6">
            <div className="relative">
              <Bell className="h-6 w-6" />
              <span className="absolute -top-2 -right-2 bg-white text-red-600 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold">
                2
              </span>
            </div>
            <div className="flex items-center space-x-2">
              <Avatar className="h-10 w-10">
                <AvatarImage src="/placeholder.svg?height=40&width=40" alt="User" />
                <AvatarFallback>JD</AvatarFallback>
              </Avatar>
              <div className="flex items-center">
                <span className="mr-2">Welcome John Doe</span>
                <ChevronDown className="h-4 w-4" />
              </div>
            </div>
          </div>
        </div>
      </header>

      <div className="container mx-auto mt-4 flex gap-6">
        {/* Sidebar */}
        <aside className="w-64 bg-white rounded-lg shadow-lg h-[calc(100vh-7rem)]">
          <nav className="p-4">
            <ul className="space-y-2">
              <li>
                <Button variant="ghost" className="w-full justify-start bg-red-50 text-red-600">
                  <LayoutDashboard className="mr-2 h-4 w-4" />
                  Dash Board
                </Button>
              </li>
              <li>
                <Button variant="ghost" className="w-full justify-start">
                  <FileText className="mr-2 h-4 w-4" />
                  View Schema
                </Button>
              </li>
              <li>
                <Button variant="ghost" className="w-full justify-start">
                  <History className="mr-2 h-4 w-4" />
                  Application History
                </Button>
              </li>
              <li>
                <Button variant="ghost" className="w-full justify-start">
                  <User className="mr-2 h-4 w-4" />
                  Profile
                </Button>
              </li>
              <li>
                <Button variant="ghost" className="w-full justify-start">
                  <Settings className="mr-2 h-4 w-4" />
                  Settings
                </Button>
              </li>
              <li>
                <Button variant="ghost" className="w-full justify-start">
                  <LogOut className="mr-2 h-4 w-4" />
                  Logout
                </Button>
              </li>
            </ul>
          </nav>
        </aside>

        {/* Main Content */}
        <main className="flex-1 bg-white rounded-lg shadow-lg p-6">
          <h2 className="text-2xl font-bold mb-6">Dash Board</h2>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <Card className="bg-red-600 text-white">
              <CardHeader className="pb-2">
                <CardTitle className="text-lg">
                  Approved Scholarship Request
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="flex justify-between items-end">
                  <span className="text-3xl font-bold">0</span>
                  <Button variant="link" className="text-white p-0 h-auto">
                    View Details
                  </Button>
                </div>
              </CardContent>
            </Card>

            <Card className="bg-red-600 text-white">
              <CardHeader className="pb-2">
                <CardTitle className="text-lg">
                  Total Scheme
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="flex justify-between items-end">
                  <span className="text-3xl font-bold">5</span>
                  <Button variant="link" className="text-white p-0 h-auto">
                    View Details
                  </Button>
                </div>
              </CardContent>
            </Card>

            <Card className="bg-red-600 text-white">
              <CardHeader className="pb-2">
                <CardTitle className="text-lg">
                  Announcement
                </CardTitle>
              </CardHeader>
              <CardContent>
                <div className="flex justify-between items-end">
                  <span className="text-3xl font-bold">0</span>
                  <Button variant="link" className="text-white p-0 h-auto">
                    View Details
                  </Button>
                </div>
              </CardContent>
            </Card>
          </div>

          <div className="mt-8">
            <h3 className="text-xl font-bold text-center mb-4">Scholarship Tracker System</h3>
            <div className="border-t border-gray-200" />
          </div>
        </main>
      </div>
    </div>
  )
}