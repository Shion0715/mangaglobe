<x-app-layout>
    <div class="bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Submit Copyright Infringement Claim</h3>
                    <p class="mt-1 max-w-full text-sm text-gray-500">If you are a copyright owner or an authorized agent and believe that your copyrighted work has been infringed upon on MangaGlobe, you may submit a copyright infringement claim. Please provide the following information:</p>
                </div>
                <div class="border-t border-gray-200 px-3">
                    <form class="divide-y divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Your Digital Signature</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="file" id="digital-signature" accept=".jpg, .png, .pdf" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                <p class="mt-2 text-xs text-gray-500">Please upload your digital signature file (JPEG, PNG, or PDF format).</p>
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Identify Copyrighted Work</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Identify the copyrighted work claimed to be infringed">
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Location of Infringement</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <input type="text" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Provide the URL or specific location of the infringing material on MangaGlobe">
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Contact Information</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="mb-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" id="address" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="mb-2">
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Unauthorized Use</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="unauthorized-use" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="unauthorized-use" class="font-medium text-gray-700">I state that the disputed use is not authorized by the copyright owner, its agent, or the law.</label>
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Perjury Statement</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="perjury-statement" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="perjury-statement" class="font-medium text-gray-700">I swear, under penalty of perjury, that the information in this notification is accurate and that I am the copyright owner or authorized to act on behalf of the copyright owner.</label>
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"></dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <button type="submit" class="inline-flex py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Submit Claim
                                </button>
                            </dd>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>